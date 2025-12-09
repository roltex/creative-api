<?php

namespace App\Filament\Resources\Sliders;

use App\Filament\Resources\Sliders\Pages\CreateSlider;
use App\Filament\Resources\Sliders\Pages\EditSlider;
use App\Filament\Resources\Sliders\Pages\ListSliders;
use App\Models\Slider;
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

class SliderResource extends Resource
{
    protected static ?string $model = Slider::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPhoto;

    protected static ?string $navigationLabel = 'სლაიდერები';

    protected static ?string $modelLabel = 'სლაიდერი';

    protected static ?string $pluralModelLabel = 'სლაიდერები';

    protected static ?int $navigationSort = 14;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Content')
                    ->tabs([
                        Tabs\Tab::make('Georgian')
                            ->schema([
                                Forms\Components\TextInput::make('title.ka')
                                    ->label('Title')
                                    ->required()
                                    ->maxLength(255),
                                
                                Forms\Components\Textarea::make('subtitle.ka')
                                    ->label('Subtitle')
                                    ->rows(2),
                                
                                Forms\Components\TextInput::make('category.ka')
                                    ->label('Category')
                                    ->maxLength(255),
                            ]),
                        
                        Tabs\Tab::make('English')
                            ->schema([
                                Forms\Components\TextInput::make('title.en')
                                    ->label('Title')
                                    ->required()
                                    ->maxLength(255),
                                
                                Forms\Components\Textarea::make('subtitle.en')
                                    ->label('Subtitle')
                                    ->rows(2),
                                
                                Forms\Components\TextInput::make('category.en')
                                    ->label('Category')
                                    ->maxLength(255),
                            ]),
                    ])
                    ->columnSpanFull(),
                
                Forms\Components\FileUpload::make('image')
                    ->label('Image')
                    ->image()
                    ->disk('public')
                    ->directory('sliders')
                    ->visibility('public')
                    ->required()
                    ->maxSize(5120)
                    ->columnSpanFull(),
                
                Forms\Components\TextInput::make('link')
                    ->label('Link URL')
                    ->url()
                    ->maxLength(255),
                
                Forms\Components\TextInput::make('button_text')
                    ->maxLength(255),
                
                Forms\Components\Select::make('location')
                    ->options([
                        'home' => 'Home Page',
                        'about' => 'About Page',
                        'other' => 'Other',
                    ])
                    ->required()
                    ->default('home'),
                
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
                Tables\Columns\TextColumn::make('title.ka')
                    ->label('Title')
                    ->searchable()
                    ->limit(40),
                Tables\Columns\TextColumn::make('location')
                    ->badge(),
                Tables\Columns\TextColumn::make('order')
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),
            ])
            ->defaultSort('order', 'asc')
            ->filters([
                Tables\Filters\SelectFilter::make('location')
                    ->options([
                        'home' => 'Home Page',
                        'about' => 'About Page',
                        'other' => 'Other',
                    ]),
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
            'index' => ListSliders::route('/'),
            'create' => CreateSlider::route('/create'),
            'edit' => EditSlider::route('/{record}/edit'),
        ];
    }
}
