<?php

namespace App\Filament\Resources\QuestionPapers\Pages;

use App\Filament\Resources\QuestionPapers\QuestionPaperResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditQuestionPaper extends EditRecord
{
    protected static string $resource = QuestionPaperResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
