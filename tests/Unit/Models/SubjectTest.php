<?php

use App\Models\Program;
use App\Models\Subject;
use App\Models\University;

test('subject can be created with factory', function (): void {
    $subject = Subject::factory()->create();

    expect($subject)->toBeInstanceOf(Subject::class)
        ->and($subject->exists)->toBeTrue();
});

test('subject has required attributes', function (): void {
    $university = University::factory()->create();
    $program = Program::factory()->create();

    $subject = Subject::factory()->create([
        'name' => 'Data Structures',
        'code' => 'CS201',
        'semester' => 3,
        'credit' => 4,
        'syllabus_url' => 'https://example.com/syllabus.pdf',
        'university_id' => $university->id,
        'program_id' => $program->id,
    ]);

    expect($subject->name)->toBe('Data Structures')
        ->and($subject->code)->toBe('CS201')
        ->and($subject->semester)->toBe(3)
        ->and($subject->credit)->toBe(4)
        ->and($subject->syllabus_url)->toBe('https://example.com/syllabus.pdf');
});

test('subject belongs to university', function (): void {
    $subject = Subject::factory()->create();

    expect($subject->university())->toBeInstanceOf(\Illuminate\Database\Eloquent\Relations\BelongsTo::class)
        ->and($subject->university)->toBeInstanceOf(University::class);
});

test('subject belongs to program', function (): void {
    $subject = Subject::factory()->create();

    expect($subject->program())->toBeInstanceOf(\Illuminate\Database\Eloquent\Relations\BelongsTo::class)
        ->and($subject->program)->toBeInstanceOf(Program::class);
});

test('subject can access its university', function (): void {
    $university = University::factory()->create(['name' => 'Test University']);
    $program = Program::factory()->create();

    $subject = Subject::factory()->create([
        'university_id' => $university->id,
        'program_id' => $program->id,
    ]);

    expect($subject->university->name)->toBe('Test University');
});

test('subject can access its program', function (): void {
    $university = University::factory()->create();
    $program = Program::factory()->create(['name' => 'Computer Science']);

    $subject = Subject::factory()->create([
        'university_id' => $university->id,
        'program_id' => $program->id,
    ]);

    expect($subject->program->name)->toBe('Computer Science');
});
