<?php

namespace App\Filament\Resources\QuestionPapers\Pages;

use App\Filament\Resources\QuestionPapers\QuestionPaperResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListQuestionPapers extends ListRecords
{
    protected static string $resource = QuestionPaperResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
