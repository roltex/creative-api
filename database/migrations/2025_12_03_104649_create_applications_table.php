<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('competition_id')->nullable()->constrained()->onDelete('set null');
            $table->enum('type', ['competition', 'funding'])->default('competition');
            $table->enum('status', ['draft', 'submitted', 'received', 'reviewing', 'approved', 'rejected'])->default('draft');
            
            // Applicant Information
            $table->string('applicant_name');
            $table->string('personal_number')->nullable();
            $table->text('address')->nullable();
            $table->string('phone');
            $table->string('email');
            
            // Project Information
            $table->string('project_name');
            $table->decimal('funding_amount', 12, 2)->nullable();
            $table->string('program')->nullable();
            $table->date('project_start_date')->nullable();
            $table->date('project_end_date')->nullable();
            $table->text('project_description')->nullable();
            $table->text('evaluation_criteria')->nullable();
            $table->text('relevant_experience')->nullable();
            
            // Budget Information
            $table->json('project_stages')->nullable();
            $table->decimal('total_budget', 12, 2)->nullable();
            $table->decimal('requested_amount', 12, 2)->nullable();
            $table->decimal('self_funding', 12, 2)->nullable();
            $table->json('expenses')->nullable();
            
            // Additional Fields
            $table->json('agreements')->nullable();
            $table->json('documents')->nullable(); // array of uploaded file paths
            $table->text('admin_notes')->nullable();
            $table->timestamp('submitted_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
