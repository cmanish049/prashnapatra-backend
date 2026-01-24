<?php

namespace App\Filament\Imports;

use App\Models\Program;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class ProgramImporter extends Importer
{
    protected static ?string $model = Program::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('name')
                ->requiredMapping()
                ->rules(['required', 'string', 'max:255'])
                ->example('Bachelor of Technology'),
            ImportColumn::make('abbreviation')
                ->requiredMapping()
                ->rules(['required', 'string', 'max:255'])
                ->example('B.Tech'),
        ];
    }

    public function resolveRecord(): ?Program
    {
        return Program::firstOrNew([
            'name' => $this->data['name'],
        ]);
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your program import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
