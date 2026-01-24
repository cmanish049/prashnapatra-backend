<?php

use App\Models\Program;
use App\Models\QuestionPaper;
use App\Models\Subject;
use App\Models\University;

test('question paper can be created with factory', function (): void {
    $questionPaper = QuestionPaper::factory()->create();

    expect($questionPaper)->toBeInstanceOf(QuestionPaper::class)
        ->and($questionPaper->exists)->toBeTrue();
});

test('question paper has required attributes', function (): void {
    $university = University::factory()->create();
    $program = Program::factory()->create();
    $subject = Subject::factory()->create([
        'university_id' => $university->id,
        'program_id' => $program->id,
    ]);

    $questionPaper = QuestionPaper::factory()->create([
        'university_id' => $university->id,
        'program_id' => $program->id,
        'subject_id' => $subject->id,
        'semester' => 5,
        'year' => '2024',
        'file_path' => 'papers/test.pdf',
        'file_url' => 'https://example.com/papers/test.pdf',
    ]);

    expect($questionPaper->semester)->toBe(5)
        ->and($questionPaper->year)->toBe('2024')
        ->and($questionPaper->file_path)->toBe('papers/test.pdf')
        ->and($questionPaper->file_url)->toBe('https://example.com/papers/test.pdf');
});

test('question paper uses soft deletes', function (): void {
    $questionPaper = QuestionPaper::factory()->create();
    $questionPaperId = $questionPaper->id;

    $questionPaper->delete();

    expect($questionPaper->trashed())->toBeTrue()
        ->and(QuestionPaper::find($questionPaperId))->toBeNull()
        ->and(QuestionPaper::withTrashed()->find($questionPaperId))->not->toBeNull();
});

test('question paper belongs to university', function (): void {
    $questionPaper = QuestionPaper::factory()->create();

    expect($questionPaper->university())->toBeInstanceOf(\Illuminate\Database\Eloquent\Relations\BelongsTo::class)
        ->and($questionPaper->university)->toBeInstanceOf(University::class);
});

test('question paper belongs to program', function (): void {
    $questionPaper = QuestionPaper::factory()->create();

    expect($questionPaper->program())->toBeInstanceOf(\Illuminate\Database\Eloquent\Relations\BelongsTo::class)
        ->and($questionPaper->program)->toBeInstanceOf(Program::class);
});

test('question paper belongs to subject', function (): void {
    $questionPaper = QuestionPaper::factory()->create();

    expect($questionPaper->subject())->toBeInstanceOf(\Illuminate\Database\Eloquent\Relations\BelongsTo::class)
        ->and($questionPaper->subject)->toBeInstanceOf(Subject::class);
});

test('question paper can access its relationships', function (): void {
    $university = University::factory()->create(['name' => 'Test University']);
    $program = Program::factory()->create(['name' => 'Test Program']);
    $subject = Subject::factory()->create([
        'name' => 'Test Subject',
        'university_id' => $university->id,
        'program_id' => $program->id,
    ]);

    $questionPaper = QuestionPaper::factory()->create([
        'university_id' => $university->id,
        'program_id' => $program->id,
        'subject_id' => $subject->id,
    ]);

    expect($questionPaper->university->name)->toBe('Test University')
        ->and($questionPaper->program->name)->toBe('Test Program')
        ->and($questionPaper->subject->name)->toBe('Test Subject');
});
