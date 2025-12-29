<?php

namespace App\Filament\Resources\Universities\Schemas;

use App\Models\University;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class UniversityInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name'),
                TextEntry::make('label'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('deleted_at')
                    ->dateTime()
                    ->visible(fn (University $record): bool => $record->trashed()),
            ]);
    }
}
