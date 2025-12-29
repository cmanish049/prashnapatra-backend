<?php

namespace App\Filament\Resources\Programs\RelationManagers;

use App\Filament\Resources\Universities\UniversityResource;
use Filament\Actions\CreateAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;

class UniversitiesRelationManager extends RelationManager
{
    protected static string $relationship = 'universities';

    protected static ?string $relatedResource = UniversityResource::class;

    public function table(Table $table): Table
    {
        return $table
            ->headerActions([
                CreateAction::make(),
            ]);
    }
}
