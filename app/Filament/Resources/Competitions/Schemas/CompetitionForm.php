<?php

namespace App\Filament\Resources\Competitions\Schemas;

use Filament\Forms;
use Filament\Forms\Form;

class CompetitionForm
{
    public static function schema(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Basic Information')
                    ->schema([
                        Forms\Components\TextInput::make('slug')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),
                        
                        Forms\Components\TextInput::make('title.ka')
                            ->label('Title (Georgian)')
                            ->required()
                            ->maxLength(255),
                        
                        Forms\Components\TextInput::make('title.en')
                            ->label('Title (English)')
                            ->required()
                            ->maxLength(255),
                        
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
                        
                        Forms\Components\TextInput::make('prize')
                            ->maxLength(255),
                        
                        Forms\Components\Toggle::make('is_featured')
                            ->default(false),
                    ])
                    ->columns(2),
                
                Forms\Components\Section::make('Description & Details')
                    ->schema([
                        Forms\Components\Textarea::make('description.ka')
                            ->label('Description (Georgian)')
                            ->required()
                            ->rows(4),
                        
                        Forms\Components\Textarea::make('description.en')
                            ->label('Description (English)')
                            ->required()
                            ->rows(4),
                        
                        Forms\Components\Textarea::make('criteria.ka')
                            ->label('Criteria (Georgian)')
                            ->rows(3),
                        
                        Forms\Components\Textarea::make('criteria.en')
                            ->label('Criteria (English)')
                            ->rows(3),
                        
                        Forms\Components\Textarea::make('rules.ka')
                            ->label('Rules (Georgian)')
                            ->rows(3),
                        
                        Forms\Components\Textarea::make('rules.en')
                            ->label('Rules (English)')
                            ->rows(3),
                    ])
                    ->columns(1),
                
                Forms\Components\Section::make('Dates & Participants')
                    ->schema([
                        Forms\Components\DatePicker::make('start_date')
                            ->required(),
                        
                        Forms\Components\DatePicker::make('end_date')
                            ->required(),
                        
                        Forms\Components\TextInput::make('max_participants')
                            ->numeric()
                            ->default(0),
                        
                        Forms\Components\TextInput::make('current_participants')
                            ->numeric()
                            ->default(0),
                    ])
                    ->columns(2),
                
                Forms\Components\Section::make('Media')
                    ->schema([
                        Forms\Components\TextInput::make('image')
                            ->label('Image URL')
                            ->url()
                            ->maxLength(500),
                        
                        Forms\Components\TextInput::make('order')
                            ->numeric()
                            ->default(0),
                    ])
                    ->columns(2),
            ]);
    }
}
