<?php

namespace App\Filament\Resources\Applications\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\Action;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Filters\SelectFilter;

class ApplicationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),
                TextColumn::make('applicant_name')
                    ->label('განმცხადებელი')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('project_name')
                    ->label('პროექტის დასახელება')
                    ->searchable()
                    ->limit(50),
                TextColumn::make('email')
                    ->label('ელფოსტა')
                    ->searchable(),
                TextColumn::make('phone')
                    ->label('ტელეფონი'),
                BadgeColumn::make('status')
                    ->label('სტატუსი')
                    ->colors([
                        'secondary' => 'draft',
                        'warning' => 'submitted',
                        'info' => 'received',
                        'primary' => 'reviewing',
                        'success' => 'approved',
                        'danger' => 'rejected',
                    ])
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'draft' => 'შავი',
                        'submitted' => 'გაგზავნილი',
                        'received' => 'მიღებული',
                        'reviewing' => 'განხილვის პროცესში',
                        'approved' => 'დამტკიცებული',
                        'rejected' => 'უარყოფილი',
                        default => $state,
                    }),
                TextColumn::make('requested_amount')
                    ->label('მოთხოვნილი თანხა')
                    ->money('GEL', locale: 'ka')
                    ->sortable(),
                TextColumn::make('submitted_at')
                    ->label('გაგზავნის თარიღი')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('სტატუსი')
                    ->options([
                        'draft' => 'შავი',
                        'submitted' => 'გაგზავნილი',
                        'received' => 'მიღებული',
                        'reviewing' => 'განხილვის პროცესში',
                        'approved' => 'დამტკიცებული',
                        'rejected' => 'უარყოფილი',
                    ]),
                SelectFilter::make('type')
                    ->label('ტიპი')
                    ->options([
                        'competition' => 'კონკურსი',
                        'funding' => 'დაფინანსება',
                    ]),
            ])
            ->recordActions([
                EditAction::make(),
                Action::make('downloadWord')
                    ->label('Word-ის ჩამოტვირთვა')
                    ->icon('heroicon-o-document-arrow-down')
                    ->color('success')
                    ->url(fn ($record) => url('/api/applications/' . $record->id . '/download/word'))
                    ->openUrlInNewTab(),
                Action::make('downloadExcel')
                    ->label('Excel-ის ჩამოტვირთვა')
                    ->icon('heroicon-o-table-cells')
                    ->color('info')
                    ->url(fn ($record) => url('/api/applications/' . $record->id . '/download/excel'))
                    ->openUrlInNewTab(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('submitted_at', 'desc');
    }
}
