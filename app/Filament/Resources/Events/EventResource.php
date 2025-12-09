<?php

namespace App\Filament\Resources\Events;

use App\Filament\Resources\Events\Pages\CreateEvent;
use App\Filament\Resources\Events\Pages\EditEvent;
use App\Filament\Resources\Events\Pages\ListEvents;
use App\Models\Event;
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

class EventResource extends Resource
{
    protected static ?string $model = Event::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCalendar;

    protected static ?string $navigationLabel = 'ღონისძიებები';

    protected static ?string $modelLabel = 'ღონისძიება';

    protected static ?string $pluralModelLabel = 'ღონისძიებები';

    protected static ?int $navigationSort = 8;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Forms\Components\TextInput::make('slug')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255)
                    ->columnSpanFull(),
                
                Tabs::make('Content')
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
                                        'h2',
                                        'h3',
                                    ])
                                    ->columnSpanFull(),
                                
                                Forms\Components\TextInput::make('location.ka')
                                    ->label('Location')
                                    ->maxLength(255),
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
                                        'h2',
                                        'h3',
                                    ])
                                    ->columnSpanFull(),
                                
                                Forms\Components\TextInput::make('location.en')
                                    ->label('Location')
                                    ->maxLength(255),
                            ]),
                    ])
                    ->columnSpanFull(),
                
                Forms\Components\Select::make('status')
                    ->options([
                        'upcoming' => 'Upcoming',
                        'ongoing' => 'Ongoing',
                        'completed' => 'Completed',
                        'cancelled' => 'Cancelled',
                    ])
                    ->required()
                    ->default('upcoming'),
                
                Forms\Components\DateTimePicker::make('start_date')
                    ->required(),
                
                Forms\Components\DateTimePicker::make('end_date'),
                
                Forms\Components\Toggle::make('is_featured')
                    ->default(false),
                
                Forms\Components\FileUpload::make('image')
                    ->label('Featured Image')
                    ->image()
                    ->disk('public')
                    ->directory('events')
                    ->visibility('public')
                    ->maxSize(5120)
                    ->columnSpanFull(),
                
                Forms\Components\FileUpload::make('gallery')
                    ->label('Gallery Images')
                    ->image()
                    ->multiple()
                    ->disk('public')
                    ->directory('events/gallery')
                    ->visibility('public')
                    ->maxSize(3072)
                    ->maxFiles(10)
                    ->reorderable()
                    ->helperText('Upload up to 10 images for the gallery')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title.ka')
                    ->label('Title')
                    ->searchable()
                    ->limit(40),
                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'warning' => 'upcoming',
                        'success' => 'ongoing',
                        'secondary' => 'completed',
                        'danger' => 'cancelled',
                    ]),
                Tables\Columns\TextColumn::make('start_date')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_featured')
                    ->boolean(),
            ])
            ->defaultSort('start_date', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'upcoming' => 'Upcoming',
                        'ongoing' => 'Ongoing',
                        'completed' => 'Completed',
                        'cancelled' => 'Cancelled',
                    ]),
                Tables\Filters\TernaryFilter::make('is_featured'),
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
            'index' => ListEvents::route('/'),
            'create' => CreateEvent::route('/create'),
            'edit' => EditEvent::route('/{record}/edit'),
        ];
    }
}
