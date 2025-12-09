<?php

namespace App\Filament\Resources\MenuItems;

use App\Filament\Resources\MenuItems\Pages\CreateMenuItem;
use App\Filament\Resources\MenuItems\Pages\EditMenuItem;
use App\Filament\Resources\MenuItems\Pages\ListMenuItems;
use App\Models\Menu;
use App\Models\MenuItem;
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

class MenuItemResource extends Resource
{
    protected static ?string $model = MenuItem::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedListBullet;

    protected static ?string $navigationLabel = 'მენიუს ელემენტები';

    protected static ?string $modelLabel = 'მენიუს ელემენტი';

    protected static ?string $pluralModelLabel = 'მენიუს ელემენტები';

    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Forms\Components\Select::make('menu_id')
                    ->label('Menu')
                    ->relationship('menu', 'name')
                    ->required()
                    ->reactive()
                    ->columnSpanFull(),
                
                Tabs::make('Content')
                    ->tabs([
                        Tabs\Tab::make('Georgian')
                            ->schema([
                                Forms\Components\TextInput::make('title.ka')
                                    ->label('Title')
                                    ->required()
                                    ->maxLength(255),
                                
                                Forms\Components\TextInput::make('subtitle.ka')
                                    ->label('Subtitle')
                                    ->maxLength(255)
                                    ->helperText('Optional subtitle text'),
                            ]),
                        
                        Tabs\Tab::make('English')
                            ->schema([
                                Forms\Components\TextInput::make('title.en')
                                    ->label('Title')
                                    ->required()
                                    ->maxLength(255),
                                
                                Forms\Components\TextInput::make('subtitle.en')
                                    ->label('Subtitle')
                                    ->maxLength(255)
                                    ->helperText('Optional subtitle text'),
                            ]),
                    ])
                    ->columnSpanFull(),
                
                Forms\Components\TextInput::make('url')
                    ->maxLength(255)
                    ->placeholder('/about-us'),
                
                Forms\Components\Select::make('target')
                    ->options([
                        '_self' => 'Same Window',
                        '_blank' => 'New Window',
                    ])
                    ->default('_self')
                    ->required(),
                
                Forms\Components\Select::make('parent_id')
                    ->label('Parent Menu Item')
                    ->relationship('parent', 'title')
                    ->searchable()
                    ->placeholder('None (Top Level)')
                    ->helperText('Select a parent to make this a submenu item'),
                
                Forms\Components\TextInput::make('order')
                    ->numeric()
                    ->default(0)
                    ->helperText('Lower numbers appear first'),
                
                Forms\Components\Toggle::make('is_active')
                    ->default(true)
                    ->label('Active'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Menu Item')
                    ->formatStateUsing(function ($state, MenuItem $record) {
                        $title = is_array($state) ? ($state['ka'] ?? $state['en'] ?? '') : $state;
                        
                        // Clean tree structure
                        if ($record->parent_id) {
                            return '├─ ' . $title;
                        }
                        
                        return $title;
                    })
                    ->searchable()
                    ->description(fn (MenuItem $record): string => 
                        is_array($record->subtitle) 
                            ? ($record->subtitle['ka'] ?? $record->subtitle['en'] ?? '') 
                            : ($record->subtitle ?? '')
                    )
                    ->weight(fn (MenuItem $record) => $record->parent_id ? 'normal' : 'bold')
                    ->color(fn (MenuItem $record) => $record->parent_id ? 'gray' : null),
                
                Tables\Columns\TextColumn::make('menu.location')
                    ->label('Placement')
                    ->badge()
                    ->colors([
                        'primary' => 'header',
                        'success' => 'footer',
                        'warning' => 'sidebar',
                        'info' => 'mobile',
                    ])
                    ->sortable(),
                Tables\Columns\TextColumn::make('url')
                    ->limit(30)
                    ->searchable(),
                
                Tables\Columns\TextColumn::make('order')
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean()
                    ->label('Active'),
            ])
            ->defaultSort('order', 'asc')
            ->filters([
                Tables\Filters\SelectFilter::make('menu_id')
                    ->label('Menu')
                    ->relationship('menu', 'name'),
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
            'index' => ListMenuItems::route('/'),
            'create' => CreateMenuItem::route('/create'),
            'edit' => EditMenuItem::route('/{record}/edit'),
        ];
    }
}
