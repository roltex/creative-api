<?php

namespace App\Filament\Resources\Faqs;

use App\Filament\Resources\Faqs\Pages\CreateFaq;
use App\Filament\Resources\Faqs\Pages\EditFaq;
use App\Filament\Resources\Faqs\Pages\ListFaqs;
use App\Models\Faq;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables;
use Filament\Tables\Table;

class FaqResource extends Resource
{
    protected static ?string $model = Faq::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedQuestionMarkCircle;

    protected static ?string $navigationLabel = 'ხ.დ.კ.';

    protected static ?string $modelLabel = 'კითხვა-პასუხი';

    protected static ?string $pluralModelLabel = 'ხშირად დასმული კითხვები';

    protected static ?int $navigationSort = 11;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Translations')
                    ->tabs([
                        Tabs\Tab::make('Georgian')
                            ->schema([
                                Forms\Components\Textarea::make('question.ka')
                                    ->label('Question')
                                    ->required()
                                    ->rows(2),
                                
                                Forms\Components\Textarea::make('answer.ka')
                                    ->label('Answer')
                                    ->required()
                                    ->rows(5),
                            ]),
                        
                        Tabs\Tab::make('English')
                            ->schema([
                                Forms\Components\Textarea::make('question.en')
                                    ->label('Question')
                                    ->required()
                                    ->rows(2),
                                
                                Forms\Components\Textarea::make('answer.en')
                                    ->label('Answer')
                                    ->required()
                                    ->rows(5),
                            ]),
                    ])
                    ->columnSpanFull(),
                
                Forms\Components\TextInput::make('category')
                    ->maxLength(255),
                
                Forms\Components\TextInput::make('order')
                    ->numeric()
                    ->default(0),
                
                Forms\Components\Toggle::make('is_active')
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('question.ka')
                    ->label('Question')
                    ->limit(60),
                Tables\Columns\TextColumn::make('category'),
                Tables\Columns\TextColumn::make('order')
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),
            ])
            ->defaultSort('order', 'asc')
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active'),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListFaqs::route('/'),
            'create' => CreateFaq::route('/create'),
            'edit' => EditFaq::route('/{record}/edit'),
        ];
    }
}
