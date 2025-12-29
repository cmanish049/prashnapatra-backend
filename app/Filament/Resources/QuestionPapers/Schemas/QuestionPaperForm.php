<?php

namespace App\Filament\Resources\QuestionPapers\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class QuestionPaperForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('subject_id')
                    ->required()
                    ->numeric(),
                TextInput::make('university_id')
                    ->required()
                    ->numeric(),
                TextInput::make('program_id')
                    ->required()
                    ->numeric(),
                TextInput::make('semester')
                    ->required()
                    ->numeric(),
                TextInput::make('file_path'),
                TextInput::make('file_url')
                    ->url(),
                TextInput::make('year')
                    ->required(),
            ]);
    }
}
