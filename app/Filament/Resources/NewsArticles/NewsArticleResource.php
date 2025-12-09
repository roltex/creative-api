<?php

namespace App\Filament\Resources\NewsArticles;

use App\Filament\Resources\NewsArticles\Pages\CreateNewsArticle;
use App\Filament\Resources\NewsArticles\Pages\EditNewsArticle;
use App\Filament\Resources\NewsArticles\Pages\ListNewsArticles;
use App\Models\NewsArticle;
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
use Illuminate\Support\Str;

class NewsArticleResource extends Resource
{
    protected static ?string $model = NewsArticle::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedNewspaper;

    protected static ?string $navigationLabel = 'სიახლეები';

    protected static ?string $modelLabel = 'სიახლე';

    protected static ?string $pluralModelLabel = 'სიახლეები';

    protected static ?int $navigationSort = 7;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Forms\Components\TextInput::make('slug')
                    ->unique(ignoreRecord: true)
                    ->maxLength(255)
                    ->placeholder('Will auto-generate from Georgian title')
                    ->helperText('Leave empty to auto-generate from Georgian title, or enter custom slug')
                    ->columnSpanFull(),
                
                Tabs::make('Content')
                    ->tabs([
                        Tabs\Tab::make('Georgian')
                            ->schema([
                                Forms\Components\TextInput::make('title.ka')
                                    ->label('Title')
                                    ->required()
                                    ->maxLength(255),
                                
                                Forms\Components\RichEditor::make('content.ka')
                                    ->label('Content')
                                    ->required()
                                    ->toolbarButtons([
                                        'bold',
                                        'italic',
                                        'underline',
                                        'link',
                                        'bulletList',
                                        'orderedList',
                                        'h2',
                                        'h3',
                                        'blockquote',
                                    ]),
                                
                                Forms\Components\Textarea::make('excerpt.ka')
                                    ->label('Excerpt')
                                    ->rows(3)
                                    ->maxLength(500)
                                    ->helperText('Short description for previews'),
                            ]),
                        
                        Tabs\Tab::make('English')
                            ->schema([
                                Forms\Components\TextInput::make('title.en')
                                    ->label('Title')
                                    ->required()
                                    ->maxLength(255),
                                
                                Forms\Components\RichEditor::make('content.en')
                                    ->label('Content')
                                    ->required()
                                    ->toolbarButtons([
                                        'bold',
                                        'italic',
                                        'underline',
                                        'link',
                                        'bulletList',
                                        'orderedList',
                                        'h2',
                                        'h3',
                                        'blockquote',
                                    ]),
                                
                                Forms\Components\Textarea::make('excerpt.en')
                                    ->label('Excerpt')
                                    ->rows(3)
                                    ->maxLength(500)
                                    ->helperText('Short description for previews'),
                            ]),
                    ])
                    ->columnSpanFull(),
                
                Forms\Components\TextInput::make('category')
                    ->required()
                    ->maxLength(255)
                    ->placeholder('e.g., გრანტები, ღონისძიებები, განათლება'),
                
                Forms\Components\Toggle::make('is_featured')
                    ->label('Featured on Homepage')
                    ->default(false)
                    ->helperText('Show this article on the homepage'),
                
                Forms\Components\DatePicker::make('published_at')
                    ->required()
                    ->default(now())
                    ->label('Publication Date'),
                
                Forms\Components\FileUpload::make('image')
                    ->label('Featured Image')
                    ->image()
                    ->disk('public')
                    ->directory('news')
                    ->visibility('public')
                    ->maxSize(5120)
                    ->required()
                    ->columnSpanFull(),
                
                Forms\Components\FileUpload::make('gallery')
                    ->label('Gallery Images')
                    ->image()
                    ->multiple()
                    ->disk('public')
                    ->directory('news/gallery')
                    ->visibility('public')
                    ->maxSize(3072)
                    ->maxFiles(10)
                    ->reorderable()
                    ->helperText('Upload up to 10 images for the gallery')
                    ->columnSpanFull(),
                
                Forms\Components\TagsInput::make('tags')
                    ->placeholder('Add tags')
                    ->helperText('Press Enter after each tag')
                    ->columnSpanFull(),
                
                Forms\Components\TextInput::make('view_count')
                    ->numeric()
                    ->default(0)
                    ->disabled()
                    ->helperText('Automatically updated when article is viewed'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->disk('public')
                    ->height(60)
                    ->width(80),
                Tables\Columns\TextColumn::make('title')
                    ->label('Title')
                    ->formatStateUsing(fn ($state) => is_array($state) ? ($state['ka'] ?? $state['en'] ?? '') : $state)
                    ->searchable()
                    ->limit(40)
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('category')
                    ->searchable()
                    ->badge()
                    ->color('primary'),
                Tables\Columns\TextColumn::make('published_at')
                    ->date()
                    ->sortable()
                    ->label('Published'),
                Tables\Columns\IconColumn::make('is_featured')
                    ->boolean()
                    ->label('Featured')
                    ->tooltip('Shows on homepage'),
                Tables\Columns\TextColumn::make('view_count')
                    ->sortable()
                    ->label('Views'),
                Tables\Columns\TextColumn::make('tags')
                    ->badge()
                    ->separator(',')
                    ->limit(2),
            ])
            ->defaultSort('published_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('category')
                    ->searchable()
                    ->multiple(),
                Tables\Filters\TernaryFilter::make('is_featured')
                    ->label('Featured Articles'),
                Tables\Filters\Filter::make('published_at')
                    ->form([
                        Forms\Components\DatePicker::make('published_from')
                            ->label('Published From'),
                        Forms\Components\DatePicker::make('published_until')
                            ->label('Published Until'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when(
                                $data['published_from'],
                                fn ($query, $date) => $query->whereDate('published_at', '>=', $date),
                            )
                            ->when(
                                $data['published_until'],
                                fn ($query, $date) => $query->whereDate('published_at', '<=', $date),
                            );
                    })
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];
                        if ($data['published_from'] ?? null) {
                            $indicators['published_from'] = 'Published from ' . $data['published_from'];
                        }
                        if ($data['published_until'] ?? null) {
                            $indicators['published_until'] = 'Published until ' . $data['published_until'];
                        }
                        return $indicators;
                    }),
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
            'index' => ListNewsArticles::route('/'),
            'create' => CreateNewsArticle::route('/create'),
            'edit' => EditNewsArticle::route('/{record}/edit'),
        ];
    }
}