<?php

use App\Models\Program;
use App\Models\University;
use Illuminate\Database\Eloquent\Collection;

test('university can be created with factory', function (): void {
    $university = University::factory()->create();

    expect($university)->toBeInstanceOf(University::class)
        ->and($university->exists)->toBeTrue();
});

test('university has required attributes', function (): void {
    $university = University::factory()->create([
        'name' => 'Tribhuvan University',
        'label' => 'tu',
    ]);

    expect($university->name)->toBe('Tribhuvan University')
        ->and($university->label)->toBe('tu');
});

test('university uses soft deletes', function (): void {
    $university = University::factory()->create();
    $universityId = $university->id;

    $university->delete();

    expect($university->trashed())->toBeTrue()
        ->and(University::find($universityId))->toBeNull()
        ->and(University::withTrashed()->find($universityId))->not->toBeNull();
});

test('university has programs relationship', function (): void {
    $university = University::factory()->create();

    expect($university->programs())->toBeInstanceOf(\Illuminate\Database\Eloquent\Relations\BelongsToMany::class)
        ->and($university->programs)->toBeInstanceOf(Collection::class);
});

test('university can have many programs', function (): void {
    $university = University::factory()->create();
    $programs = Program::factory()->count(3)->create();

    $university->programs()->attach($programs);

    expect($university->programs)->toHaveCount(3)
        ->and($university->programs->first())->toBeInstanceOf(Program::class);
});
