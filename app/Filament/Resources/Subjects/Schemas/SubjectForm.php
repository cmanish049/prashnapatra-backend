<?php

namespace App\Filament\Resources\Subjects\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class SubjectForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('code')
                    ->required(),
                TextInput::make('semester')
                    ->required()
                    ->numeric(),
                TextInput::make('credit')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('syllabus_url')
                    ->url()
                    ->required(),
                Select::make('university_id')
                    ->relationship('university', 'name')
                    ->required()
                    ->preload()
                    ->searchable(),
                Select::make('program_id')
                    ->relationship('program', 'name')
                    ->required()
                    ->preload()
                    ->searchable(),
            ]);
    }
}
