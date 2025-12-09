<?php

namespace App\Filament\Resources\Applications\Pages;

use App\Filament\Resources\Applications\ApplicationResource;
use App\Services\ApplicationDocumentService;
use Filament\Actions\DeleteAction;
use Filament\Actions\Action;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;

class EditApplication extends EditRecord
{
    protected static string $resource = ApplicationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('regenerateDocuments')
                ->label('დოკუმენტების ხელახლა გენერაცია')
                ->icon('heroicon-o-arrow-path')
                ->color('warning')
                ->requiresConfirmation()
                ->modalHeading('დოკუმენტების ხელახლა გენერაცია')
                ->modalDescription('დარწმუნებული ხართ, რომ გსურთ დოკუმენტების ხელახლა გენერაცია? არსებული დოკუმენტები შეიცვლება.')
                ->modalSubmitActionLabel('დიახ, გენერაცია')
                ->action(function () {
                    try {
                        // Use Laravel's service container to resolve dependencies
                        $documentService = app(ApplicationDocumentService::class);
                        $documentService->generateDocuments($this->record);
                        
                        Notification::make()
                            ->title('დოკუმენტები წარმატებით გენერირდა')
                            ->success()
                            ->send();
                    } catch (\Exception $e) {
                        Notification::make()
                            ->title('შეცდომა')
                            ->body('დოკუმენტების გენერაციისას მოხდა შეცდომა: ' . $e->getMessage())
                            ->danger()
                            ->send();
                    }
                }),
            Action::make('downloadWord')
                ->label('Word-ის ჩამოტვირთვა')
                ->icon('heroicon-o-document-arrow-down')
                ->color('success')
                ->url(fn () => url('/api/applications/' . $this->record->id . '/download/word'))
                ->openUrlInNewTab(),
            Action::make('downloadExcel')
                ->label('Excel-ის ჩამოტვირთვა')
                ->icon('heroicon-o-table-cells')
                ->color('info')
                ->url(fn () => url('/api/applications/' . $this->record->id . '/download/excel'))
                ->openUrlInNewTab(),
            DeleteAction::make(),
        ];
    }
}
