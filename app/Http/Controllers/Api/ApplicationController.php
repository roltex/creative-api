<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Services\ApplicationDocumentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ApplicationController extends Controller
{
    protected ApplicationDocumentService $documentService;

    public function __construct(ApplicationDocumentService $documentService)
    {
        $this->documentService = $documentService;
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'applicantType' => 'required|in:legal_entity,individual',
            'applicationType' => 'required|in:competitive,non_competitive',
            'title' => 'required|string|max:255',
            'requestedAmountGel' => 'required|numeric|min:0',
            'startDate' => 'required|date',
            'endDate' => 'required|date|after:startDate',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Use database transaction to ensure atomicity
            $application = DB::transaction(function () use ($request) {
                $application = Application::create([
                    'user_id' => auth()->id(),
                    'type' => $request->applicationType === 'competitive' ? 'competition' : 'funding',
                    'status' => 'submitted',
                    
                    // Applicant Information
                    'applicant_name' => $request->applicantName ?? ($request->orgName ?? $request->personFullName ?? ''),
                    'personal_number' => $request->personalNumber ?? ($request->orgIdCode ?? $request->personIdNumber ?? null),
                    'address' => $request->address ?? ($request->orgAddress ?? null),
                    'phone' => $request->phone ?? ($request->orgPhone ?? $request->personPhone ?? ''),
                    'email' => $request->email ?? ($request->orgEmail ?? $request->personEmail ?? ''),
                    
                    // Project Information
                    'project_name' => $request->title,
                    'funding_amount' => $request->requestedAmountGel,
                    'program' => $request->competitionTitle ?? null,
                    'project_start_date' => $request->startDate,
                    'project_end_date' => $request->endDate,
                    'project_description' => $request->projectDescription ?? null,
                    'evaluation_criteria' => $request->evaluationCriteria ?? null,
                    'relevant_experience' => $request->experience ?? null,
                    
                    // Budget Information
                    'total_budget' => $request->totalBudgetGel ?? 0,
                    'requested_amount' => $request->requestedFromCreativeGeorgia ?? $request->requestedAmountGel,
                    'self_funding' => $request->selfFundingGel ?? 0,
                    'project_stages' => $request->stages ?? [],
                    'expenses' => $request->expenseCategories ?? [],
                    
                    // Additional Fields
                    'agreements' => $request->agreements ?? [],
                    'documents' => [],
                    'admin_notes' => null,
                    'submitted_at' => now(),
                    
                    // Store full form data as JSON for complete record
                    'form_data' => $request->all(),
                ]);

                return $application;
            });

            // Generate documents AFTER transaction commits (outside transaction to avoid blocking)
            try {
                $this->documentService->generateDocuments($application);
            } catch (\Exception $e) {
                // Log error but don't fail the submission
                Log::error('Failed to generate documents for application ' . $application->id . ': ' . $e->getMessage());
                Log::error('Stack trace: ' . $e->getTraceAsString());
            }

            return response()->json([
                'success' => true,
                'message' => 'Application submitted successfully',
                'data' => [
                    'id' => $application->id,
                    'application_number' => 'APP-' . str_pad($application->id, 6, '0', STR_PAD_LEFT),
                ]
            ], 201);
        } catch (\Exception $e) {
            Log::error('Application submission failed: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to submit application',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Download Word document for an application
     */
    public function downloadWord($id)
    {
        $application = Application::findOrFail($id);
        
        $documents = $application->documents ?? [];
        $wordPath = $documents['word'] ?? null;

        if (!$wordPath || !Storage::exists($wordPath)) {
            return response()->json([
                'success' => false,
                'message' => 'Word document not found'
            ], 404);
        }

        return Storage::download($wordPath, 'დანართი_N_2.1_' . $application->id . '.docx');
    }

    /**
     * Download Excel document for an application
     */
    public function downloadExcel($id)
    {
        $application = Application::findOrFail($id);
        
        $documents = $application->documents ?? [];
        $excelPath = $documents['excel'] ?? null;

        if (!$excelPath || !Storage::exists($excelPath)) {
            return response()->json([
                'success' => false,
                'message' => 'Excel document not found'
            ], 404);
        }

        return Storage::download($excelPath, 'დანართი_N2.2_' . $application->id . '.xlsx');
    }

    /**
     * Regenerate documents for an application
     */
    public function regenerateDocuments($id)
    {
        $application = Application::findOrFail($id);
        
        try {
            $this->documentService->generateDocuments($application);
            
            return response()->json([
                'success' => true,
                'message' => 'Documents regenerated successfully!',
                'documents' => $application->fresh()->documents,
            ]);
        } catch (\Exception $e) {
            Log::error("Failed to regenerate documents for application {$application->id}: " . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to regenerate documents: ' . $e->getMessage()
            ], 500);
        }
    }
}

