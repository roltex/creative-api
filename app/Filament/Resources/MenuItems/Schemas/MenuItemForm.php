<?php

namespace App\Filament\Resources\MenuItems\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class MenuItemForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('menu_id')
                    ->required()
                    ->numeric(),
                TextInput::make('parent_id')
                    ->numeric(),
                Textarea::make('title')
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('url')
                    ->url(),
                TextInput::make('route_name'),
                TextInput::make('target')
                    ->required()
                    ->default('_self'),
                TextInput::make('icon'),
                TextInput::make('order')
                    ->required()
                    ->numeric()
                    ->default(0),
                Toggle::make('is_active')
                    ->required(),
            ]);
    }
}
