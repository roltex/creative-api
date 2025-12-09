<?php

namespace App\Filament\Resources\SuccessStories\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class SuccessStoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('slug')
                    ->required(),
                Textarea::make('title')
                    ->required()
                    ->columnSpanFull(),
                Textarea::make('description')
                    ->required()
                    ->columnSpanFull(),
                Textarea::make('story')
                    ->columnSpanFull(),
                Textarea::make('achievements')
                    ->columnSpanFull(),
                FileUpload::make('image')
                    ->image(),
                Textarea::make('gallery')
                    ->columnSpanFull(),
                TextInput::make('category'),
                TextInput::make('competition_name'),
                TextInput::make('year')
                    ->numeric(),
                TextInput::make('amount'),
                TextInput::make('creator_name'),
                Toggle::make('is_featured')
                    ->required(),
                TextInput::make('order')
                    ->required()
                    ->numeric()
                    ->default(0),
            ]);
    }
}
