<?php

use App\Filament\Imports\ProgramImporter;
use App\Filament\Resources\Programs\Pages\ListPrograms;
use App\Models\Program;
use App\Models\User;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Models\Import;
use Livewire\Livewire;

use function Pest\Laravel\actingAs;

beforeEach(function () {
    $this->user = User::factory()->create();
});

test('program importer has correct columns defined', function () {
    $columns = ProgramImporter::getColumns();

    expect($columns)->toHaveCount(2);
    expect($columns[0])->toBeInstanceOf(ImportColumn::class);
    expect($columns[1])->toBeInstanceOf(ImportColumn::class);
});

test('program importer uses name for matching existing records', function () {
    $existingProgram = Program::factory()->create([
        'name' => 'Bachelor of Technology',
        'abbreviation' => 'B.Tech',
    ]);

    $import = Import::create([
        'user_id' => $this->user->id,
        'importer' => ProgramImporter::class,
        'file_name' => 'test.csv',
        'file_path' => 'imports/test.csv',
        'total_rows' => 1,
        'processed_rows' => 0,
        'successful_rows' => 0,
    ]);

    $importer = new ProgramImporter($import, [], []);

    $dataProperty = new ReflectionProperty($importer, 'data');
    $dataProperty->setValue($importer, ['name' => 'Bachelor of Technology']);

    $record = $importer->resolveRecord();

    expect($record->exists)->toBeTrue();
    expect($record->id)->toBe($existingProgram->id);
});

test('program importer creates new record for non-existing name', function () {
    $import = Import::create([
        'user_id' => $this->user->id,
        'importer' => ProgramImporter::class,
        'file_name' => 'test.csv',
        'file_path' => 'imports/test.csv',
        'total_rows' => 1,
        'processed_rows' => 0,
        'successful_rows' => 0,
    ]);

    $importer = new ProgramImporter($import, [], []);

    $dataProperty = new ReflectionProperty($importer, 'data');
    $dataProperty->setValue($importer, ['name' => 'Master of Science']);

    $record = $importer->resolveRecord();

    expect($record->exists)->toBeFalse();
    expect($record->name)->toBe('Master of Science');
});

test('list programs page has import action', function () {
    actingAs($this->user);

    Livewire::test(ListPrograms::class)
        ->assertActionExists('import');
});
