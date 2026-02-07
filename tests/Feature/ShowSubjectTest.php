<?php

use App\Models\Program;
use App\Models\Subject;
use App\Models\University;

test('it can get a subject by id with university and program', function (): void {
    $university = University::factory()->create();
    $program = Program::factory()->create();
    $subject = Subject::factory()->create([
        'university_id' => $university->id,
        'program_id' => $program->id,
    ]);

    $this->withApiKey()
        ->getJson(route('api.v1.subjects.show', ['subjectId' => $subject->id]))
        ->assertSuccessful()
        ->assertJson([
            'status' => 'success',
            'error' => false,
        ])
        ->assertJsonFragment([
            'subject_id' => $subject->id,
            'name' => $subject->name,
            'code' => $subject->code,
            'description' => $subject->description,
            'semester' => $subject->semester,
            'credit' => $subject->credit,
            'syllabus_url' => $subject->syllabus_url,
        ])
        ->assertJsonFragment([
            'university' => [
                'university_id' => $university->id,
                'name' => $university->name,
                'label' => $university->label,
            ],
        ])
        ->assertJsonFragment([
            'program' => [
                'program_id' => $program->id,
                'name' => $program->name,
                'abbreviation' => $program->abbreviation,
            ],
        ]);
});

test('it returns 404 when subject does not exist', function (): void {
    $this->withApiKey()
        ->getJson(route('api.v1.subjects.show', ['subjectId' => 99999]))
        ->assertStatus(404)
        ->assertJson([
            'status' => 'error',
            'error' => true,
            'message' => 'Subject not found',
        ]);
});

test('it requires authentication to get subject details', function (): void {
    $subject = Subject::factory()->create();

    $this->getJson(route('api.v1.subjects.show', ['subjectId' => $subject->id]))
        ->assertStatus(401);
});

test('it returns complete subject data structure', function (): void {
    $university = University::factory()->create();
    $program = Program::factory()->create();
    $subject = Subject::factory()->create([
        'university_id' => $university->id,
        'program_id' => $program->id,
    ]);

    $response = $this->withApiKey()
        ->getJson(route('api.v1.subjects.show', ['subjectId' => $subject->id]))
        ->assertSuccessful();

    $data = $response->json('data');

    expect($data)->toHaveKeys([
        'subject_id',
        'name',
        'code',
        'description',
        'semester',
        'credit',
        'syllabus_url',
        'university',
        'program',
    ]);

    expect($data['university'])->toHaveKeys(['university_id', 'name', 'label']);
    expect($data['program'])->toHaveKeys(['program_id', 'name', 'abbreviation']);
});
