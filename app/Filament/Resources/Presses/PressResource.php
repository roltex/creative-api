<?php

namespace App\Filament\Resources\Presses;

use App\Filament\Resources\Presses\Pages\CreatePress;
use App\Filament\Resources\Presses\Pages\EditPress;
use App\Filament\Resources\Presses\Pages\ListPresses;
use App\Models\Press;
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

class PressResource extends Resource
{
    protected static ?string $model = Press::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedMegaphone;

    protected static ?string $navigationLabel = 'პრესა';

    protected static ?string $modelLabel = 'პრეს-რელიზი';

    protected static ?string $pluralModelLabel = 'პრეს-რელიზები';

    protected static ?int $navigationSort = 9;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                // პრეს-რელიზის სათაური (Georgian/English)
                Tabs::make('Press Title')
                    ->tabs([
                        Tabs\Tab::make('Georgian')
                            ->schema([
                                Forms\Components\TextInput::make('press_title.ka')
                                    ->label('პრეს-რელიზის სათაური')
                                    ->required()
                                    ->maxLength(255),
                            ]),
                        
                        Tabs\Tab::make('English')
                            ->schema([
                                Forms\Components\TextInput::make('press_title.en')
                                    ->label('Press Release Title')
                                    ->required()
                                    ->maxLength(255),
                            ]),
                    ])
                    ->columnSpanFull(),
                
                // მედიის დასახელება (Georgian/English)
                Tabs::make('Media Name')
                    ->tabs([
                        Tabs\Tab::make('Georgian')
                            ->schema([
                                Forms\Components\TextInput::make('media_name.ka')
                                    ->label('მედიის დასახელება')
                                    ->required()
                                    ->maxLength(255)
                                    ->placeholder('მაგ., რუსთავი 2, პირველი არხი, იმედი')
                            ]),
                        
                        Tabs\Tab::make('English')
                            ->schema([
                                Forms\Components\TextInput::make('media_name.en')
                                    ->label('Media Name')
                                    ->required()
                                    ->maxLength(255)
                                    ->placeholder('e.g., Rustavi 2, First Channel, Imedi TV')
                            ]),
                    ])
                    ->columnSpanFull(),
                
                // ბმული
                Forms\Components\TextInput::make('media_link')
                    ->label('ბმული')
                    ->url()
                    ->maxLength(500)
                    ->placeholder('https://tv.com/news/article')
                    ->helperText('Link to the original coverage')
                    ->columnSpanFull(),
                
                // მედიის ლოგო
                Forms\Components\FileUpload::make('media_logo')
                    ->label('მედიის ლოგო')
                    ->image()
                    ->disk('public')
                    ->directory('press/logos')
                    ->visibility('public')
                    ->maxSize(2048)
                    ->helperText('Upload media outlet logo')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('media_logo')
                    ->label('Logo')
                    ->disk('public')
                    ->height(50)
                    ->width(80),
                    
                Tables\Columns\TextColumn::make('press_title')
                    ->label('პრეს-რელიზის სათაური')
                    ->formatStateUsing(fn ($state) => is_array($state) ? ($state['ka'] ?? $state['en'] ?? '') : $state)
                    ->searchable()
                    ->limit(50)
                    ->weight('bold'),
                    
                Tables\Columns\TextColumn::make('media_name')
                    ->label('მედიის დასახელება')
                    ->formatStateUsing(fn ($state) => is_array($state) ? ($state['ka'] ?? $state['en'] ?? '') : $state)
                    ->searchable()
                    ->badge()
                    ->color('primary'),
                    
                Tables\Columns\TextColumn::make('media_link')
                    ->label('ბმული')
                    ->limit(40)
                    ->url(fn ($record) => $record->media_link, shouldOpenInNewTab: true)
                    ->icon('heroicon-o-arrow-top-right-on-square'),
                    
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('media_name')
                    ->label('Media Outlet')
                    ->options(function () {
                        return Press::all()
                            ->mapWithKeys(function ($press) {
                                $name = is_array($press->media_name) 
                                    ? ($press->media_name['ka'] ?? $press->media_name['en'] ?? '')
                                    : $press->media_name;
                                return [$press->id => $name];
                            });
                    })
                    ->searchable(),
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
            'index' => ListPresses::route('/'),
            'create' => CreatePress::route('/create'),
            'edit' => EditPress::route('/{record}/edit'),
        ];
    }
}