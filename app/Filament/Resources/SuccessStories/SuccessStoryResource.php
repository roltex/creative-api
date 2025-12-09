<?php

namespace App\Filament\Resources\SuccessStories;

use App\Filament\Resources\SuccessStories\Pages\CreateSuccessStory;
use App\Filament\Resources\SuccessStories\Pages\EditSuccessStory;
use App\Filament\Resources\SuccessStories\Pages\ListSuccessStories;
use App\Models\SuccessStory;
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

class SuccessStoryResource extends Resource
{
    protected static ?string $model = SuccessStory::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedStar;

    protected static ?string $navigationLabel = 'წარმატების ისტორიები';

    protected static ?string $modelLabel = 'წარმატების ისტორია';

    protected static ?string $pluralModelLabel = 'წარმატების ისტორიები';

    protected static ?int $navigationSort = 6;

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
                                
                                Forms\Components\Textarea::make('description.ka')
                                    ->label('Short Description')
                                    ->required()
                                    ->rows(3),
                                
                                Forms\Components\RichEditor::make('story.ka')
                                    ->label('Full Story')
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
                            ]),
                        
                        Tabs\Tab::make('English')
                            ->schema([
                                Forms\Components\TextInput::make('title.en')
                                    ->label('Title')
                                    ->required()
                                    ->maxLength(255),
                                
                                Forms\Components\Textarea::make('description.en')
                                    ->label('Short Description')
                                    ->required()
                                    ->rows(3),
                                
                                Forms\Components\RichEditor::make('story.en')
                                    ->label('Full Story')
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
                            ]),
                    ])
                    ->columnSpanFull(),
                
                Forms\Components\TextInput::make('creator_name')
                    ->maxLength(255),
                
                Forms\Components\TextInput::make('category')
                    ->maxLength(255),
                
                Forms\Components\TextInput::make('competition_name')
                    ->label('Competition Name')
                    ->maxLength(255),
                
                Forms\Components\TextInput::make('year')
                    ->numeric()
                    ->minValue(2000)
                    ->maxValue(2099),
                
                Forms\Components\TextInput::make('amount')
                    ->maxLength(255)
                    ->placeholder('e.g., ₾50,000'),
                
                Forms\Components\TagsInput::make('achievements')
                    ->placeholder('Add achievements')
                    ->helperText('Press enter after each achievement')
                    ->columnSpanFull(),
                
                Forms\Components\Toggle::make('is_featured')
                    ->default(false),
                
                Forms\Components\TextInput::make('order')
                    ->numeric()
                    ->default(0),
                
                Forms\Components\FileUpload::make('image')
                    ->label('Image')
                    ->image()
                    ->disk('public')
                    ->directory('success-stories')
                    ->visibility('public')
                    ->maxSize(5120)
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
                Tables\Columns\TextColumn::make('creator_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('category')
                    ->searchable(),
                Tables\Columns\TextColumn::make('year')
                    ->sortable(),
                Tables\Columns\TextColumn::make('amount'),
                Tables\Columns\IconColumn::make('is_featured')
                    ->boolean(),
                Tables\Columns\TextColumn::make('order')
                    ->sortable(),
            ])
            ->defaultSort('order', 'asc')
            ->filters([
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
            'index' => ListSuccessStories::route('/'),
            'create' => CreateSuccessStory::route('/create'),
            'edit' => EditSuccessStory::route('/{record}/edit'),
        ];
    }
}
