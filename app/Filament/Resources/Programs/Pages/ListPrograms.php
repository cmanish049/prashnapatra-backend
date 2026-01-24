<?php

namespace App\Filament\Resources\Programs\Pages;

use App\Filament\Imports\ProgramImporter;
use App\Filament\Resources\Programs\ProgramResource;
use Filament\Actions\CreateAction;
use Filament\Actions\ImportAction;
use Filament\Resources\Pages\ListRecords;

class ListPrograms extends ListRecords
{
    protected static string $resource = ProgramResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ImportAction::make()
                ->importer(ProgramImporter::class),
            CreateAction::make(),
        ];
    }
}
