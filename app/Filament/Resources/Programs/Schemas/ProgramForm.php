<?php

namespace App\Filament\Resources\Programs\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ProgramForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('abbreviation')
                    ->required(),
                Select::make('universities')
                    ->relationship('universities', 'name')
                    ->multiple()
                    ->preload()
                    ->searchable(),
            ]);
    }
}
