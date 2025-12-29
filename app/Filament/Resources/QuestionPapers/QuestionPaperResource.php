<?php

namespace App\Filament\Resources\QuestionPapers;

use App\Filament\Resources\QuestionPapers\Pages\CreateQuestionPaper;
use App\Filament\Resources\QuestionPapers\Pages\EditQuestionPaper;
use App\Filament\Resources\QuestionPapers\Pages\ListQuestionPapers;
use App\Filament\Resources\QuestionPapers\Schemas\QuestionPaperForm;
use App\Filament\Resources\QuestionPapers\Tables\QuestionPapersTable;
use App\Models\QuestionPaper;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class QuestionPaperResource extends Resource
{
    protected static ?string $model = QuestionPaper::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return QuestionPaperForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return QuestionPapersTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListQuestionPapers::route('/'),
            'create' => CreateQuestionPaper::route('/create'),
            'edit' => EditQuestionPaper::route('/{record}/edit'),
        ];
    }
}
