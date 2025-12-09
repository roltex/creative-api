<?php

namespace App\Filament\Resources\Competitions;

use App\Filament\Resources\Competitions\Pages\CreateCompetition;
use App\Filament\Resources\Competitions\Pages\EditCompetition;
use App\Filament\Resources\Competitions\Pages\ListCompetitions;
use App\Models\Competition;
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

class CompetitionResource extends Resource
{
    protected static ?string $model = Competition::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedTrophy;

    protected static ?string $navigationLabel = 'კონკურსები';

    protected static ?string $modelLabel = 'კონკურსი';

    protected static ?string $pluralModelLabel = 'კონკურსები';

    protected static ?int $navigationSort = 5;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Forms\Components\TextInput::make('slug')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255)
                    ->columnSpanFull(),
                
                Tabs::make('Translations')
                    ->tabs([
                        Tabs\Tab::make('Georgian')
                            ->schema([
                                Forms\Components\TextInput::make('title.ka')
                                    ->label('Title')
                                    ->required()
                                    ->maxLength(255),
                                
                                Forms\Components\RichEditor::make('description.ka')
                                    ->label('Description')
                                    ->required()
                                    ->toolbarButtons([
                                        'bold',
                                        'italic',
                                        'underline',
                                        'strike',
                                        'link',
                                        'bulletList',
                                        'orderedList',
                                        'blockquote',
                                        'codeBlock',
                                    ])
                                    ->columnSpanFull(),
                            ]),
                        
                        Tabs\Tab::make('English')
                            ->schema([
                                Forms\Components\TextInput::make('title.en')
                                    ->label('Title')
                                    ->required()
                                    ->maxLength(255),
                                
                                Forms\Components\RichEditor::make('description.en')
                                    ->label('Description')
                                    ->required()
                                    ->toolbarButtons([
                                        'bold',
                                        'italic',
                                        'underline',
                                        'strike',
                                        'link',
                                        'bulletList',
                                        'orderedList',
                                        'blockquote',
                                        'codeBlock',
                                    ])
                                    ->columnSpanFull(),
                            ]),
                    ])
                    ->columnSpanFull(),
                
                Forms\Components\Select::make('status')
                    ->options([
                        'upcoming' => 'Upcoming',
                        'current' => 'Current',
                        'completed' => 'Completed',
                        'cancelled' => 'Cancelled',
                    ])
                    ->required()
                    ->default('current'),
                
                Forms\Components\TextInput::make('category')
                    ->maxLength(255),
                
                Forms\Components\DatePicker::make('start_date')
                    ->required(),
                
                Forms\Components\DatePicker::make('end_date')
                    ->required(),
                
                Forms\Components\FileUpload::make('image')
                    ->label('Image')
                    ->image()
                    ->disk('public')
                    ->directory('competitions')
                    ->visibility('public')
                    ->maxSize(5120)
                    ->columnSpanFull(),
                
                Forms\Components\TextInput::make('order')
                    ->numeric()
                    ->default(0),
                
                Forms\Components\Toggle::make('is_featured')
                    ->default(false),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title.ka')
                    ->label('Title')
                    ->searchable()
                    ->limit(50),
                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'warning' => 'upcoming',
                        'success' => 'current',
                        'secondary' => 'completed',
                        'danger' => 'cancelled',
                    ]),
                Tables\Columns\TextColumn::make('category')
                    ->searchable(),
                Tables\Columns\TextColumn::make('start_date')
                    ->date(),
                Tables\Columns\TextColumn::make('end_date')
                    ->date(),
                Tables\Columns\IconColumn::make('is_featured')
                    ->boolean(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'upcoming' => 'Upcoming',
                        'current' => 'Current',
                        'completed' => 'Completed',
                        'cancelled' => 'Cancelled',
                    ]),
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
            'index' => ListCompetitions::route('/'),
            'create' => CreateCompetition::route('/create'),
            'edit' => EditCompetition::route('/{record}/edit'),
        ];
    }
}
