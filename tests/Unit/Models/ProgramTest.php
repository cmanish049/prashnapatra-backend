<?php

use App\Models\Program;
use App\Models\Subject;
use App\Models\University;
use Illuminate\Database\Eloquent\Collection;

test('program can be created with factory', function () {
    $program = Program::factory()->create();

    expect($program)->toBeInstanceOf(Program::class)
        ->and($program->exists)->toBeTrue();
});

test('program has required attributes', function () {
    $program = Program::factory()->create([
        'name' => 'Bachelor of Computer Science',
        'abbreviation' => 'BCS',
    ]);

    expect($program->name)->toBe('Bachelor of Computer Science')
        ->and($program->abbreviation)->toBe('BCS');
});

test('program has universities relationship', function () {
    $program = Program::factory()->create();

    expect($program->universities())->toBeInstanceOf(\Illuminate\Database\Eloquent\Relations\BelongsToMany::class)
        ->and($program->universities)->toBeInstanceOf(Collection::class);
});

test('program can belong to many universities', function () {
    $program = Program::factory()->create();
    $universities = University::factory()->count(2)->create();

    $program->universities()->attach($universities);

    expect($program->universities)->toHaveCount(2)
        ->and($program->universities->first())->toBeInstanceOf(University::class);
});

test('program has subjects relationship', function () {
    $program = Program::factory()->create();

    expect($program->subjects())->toBeInstanceOf(\Illuminate\Database\Eloquent\Relations\HasMany::class)
        ->and($program->subjects)->toBeInstanceOf(Collection::class);
});

test('program can have many subjects', function () {
    $university = University::factory()->create();
    $program = Program::factory()->create();

    Subject::factory()->count(3)->create([
        'university_id' => $university->id,
        'program_id' => $program->id,
    ]);

    expect($program->subjects)->toHaveCount(3)
        ->and($program->subjects->first())->toBeInstanceOf(Subject::class);
});
