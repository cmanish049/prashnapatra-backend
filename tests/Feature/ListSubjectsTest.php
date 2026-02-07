<?php

use App\Models\Program;
use App\Models\Subject;
use App\Models\University;

test('it returns empty list when no subjects exist', function (): void {
    $this->withApiKey()
        ->getJson(route('api.v1.subjects.index'))
        ->assertSuccessful()
        ->assertJson([
            'status' => 'success',
            'error' => false,
        ])
        ->assertJsonCount(0, 'data');
});

test('it can list all subjects with university and program', function (): void {
    $university = University::factory()->create();
    $program = Program::factory()->create();
    $subject = Subject::factory()->create([
        'university_id' => $university->id,
        'program_id' => $program->id,
    ]);

    $this->withApiKey()
        ->getJson(route('api.v1.subjects.index'))
        ->assertSuccessful()
        ->assertJson([
            'status' => 'success',
            'error' => false,
        ])
        ->assertJsonCount(1, 'data')
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

test('it paginates subjects at 20 per page', function (): void {
    $university = University::factory()->create();
    $program = Program::factory()->create();
    Subject::factory()->count(25)->create([
        'university_id' => $university->id,
        'program_id' => $program->id,
    ]);

    $this->withApiKey()
        ->getJson(route('api.v1.subjects.index'))
        ->assertSuccessful()
        ->assertJson([
            'status' => 'success',
            'error' => false,
        ])
        ->assertJsonCount(20, 'data');
});

test('it can navigate to second page of subjects', function (): void {
    $university = University::factory()->create();
    $program = Program::factory()->create();
    Subject::factory()->count(25)->create([
        'university_id' => $university->id,
        'program_id' => $program->id,
    ]);

    $this->withApiKey()
        ->getJson(route('api.v1.subjects.index', ['page' => 2]))
        ->assertSuccessful()
        ->assertJson([
            'status' => 'success',
            'error' => false,
        ])
        ->assertJsonCount(5, 'data');
});

test('it can filter subjects by university', function (): void {
    $university1 = University::factory()->create();
    $university2 = University::factory()->create();
    $program = Program::factory()->create();

    Subject::factory()->count(3)->create([
        'university_id' => $university1->id,
        'program_id' => $program->id,
    ]);
    Subject::factory()->count(2)->create([
        'university_id' => $university2->id,
        'program_id' => $program->id,
    ]);

    $this->withApiKey()
        ->getJson(route('api.v1.subjects.index', ['university' => $university1->id]))
        ->assertSuccessful()
        ->assertJson([
            'status' => 'success',
            'error' => false,
        ])
        ->assertJsonCount(3, 'data');
});

test('it can filter subjects by program', function (): void {
    $university = University::factory()->create();
    $program1 = Program::factory()->create();
    $program2 = Program::factory()->create();

    Subject::factory()->count(4)->create([
        'university_id' => $university->id,
        'program_id' => $program1->id,
    ]);
    Subject::factory()->count(2)->create([
        'university_id' => $university->id,
        'program_id' => $program2->id,
    ]);

    $this->withApiKey()
        ->getJson(route('api.v1.subjects.index', ['program' => $program1->id]))
        ->assertSuccessful()
        ->assertJson([
            'status' => 'success',
            'error' => false,
        ])
        ->assertJsonCount(4, 'data');
});

test('it can filter subjects by semester', function (): void {
    $university = University::factory()->create();
    $program = Program::factory()->create();

    Subject::factory()->count(3)->create([
        'university_id' => $university->id,
        'program_id' => $program->id,
        'semester' => 1,
    ]);
    Subject::factory()->count(2)->create([
        'university_id' => $university->id,
        'program_id' => $program->id,
        'semester' => 2,
    ]);

    $this->withApiKey()
        ->getJson(route('api.v1.subjects.index', ['semester' => 1]))
        ->assertSuccessful()
        ->assertJson([
            'status' => 'success',
            'error' => false,
        ])
        ->assertJsonCount(3, 'data');
});

test('it can filter subjects by multiple parameters', function (): void {
    $university1 = University::factory()->create();
    $university2 = University::factory()->create();
    $program1 = Program::factory()->create();
    $program2 = Program::factory()->create();

    // Matches all filters
    Subject::factory()->count(2)->create([
        'university_id' => $university1->id,
        'program_id' => $program1->id,
        'semester' => 1,
    ]);

    // Matches only university and semester
    Subject::factory()->count(1)->create([
        'university_id' => $university1->id,
        'program_id' => $program2->id,
        'semester' => 1,
    ]);

    // Matches only program and semester
    Subject::factory()->count(1)->create([
        'university_id' => $university2->id,
        'program_id' => $program1->id,
        'semester' => 1,
    ]);

    // Doesn't match semester
    Subject::factory()->count(1)->create([
        'university_id' => $university1->id,
        'program_id' => $program1->id,
        'semester' => 2,
    ]);

    $this->withApiKey()
        ->getJson(route('api.v1.subjects.index', [
            'university' => $university1->id,
            'program' => $program1->id,
            'semester' => 1,
        ]))
        ->assertSuccessful()
        ->assertJson([
            'status' => 'success',
            'error' => false,
        ])
        ->assertJsonCount(2, 'data');
});

test('it returns empty list when filters do not match any subjects', function (): void {
    $university = University::factory()->create();
    $program = Program::factory()->create();

    Subject::factory()->create([
        'university_id' => $university->id,
        'program_id' => $program->id,
        'semester' => 1,
    ]);

    $this->withApiKey()
        ->getJson(route('api.v1.subjects.index', ['semester' => 5]))
        ->assertSuccessful()
        ->assertJson([
            'status' => 'success',
            'error' => false,
        ])
        ->assertJsonCount(0, 'data');
});

test('it validates university parameter must be an integer', function (): void {
    $this->withApiKey()
        ->getJson(route('api.v1.subjects.index', ['university' => 'invalid']))
        ->assertStatus(422)
        ->assertJsonValidationErrors(['university']);
});

test('it validates university parameter must exist', function (): void {
    $this->withApiKey()
        ->getJson(route('api.v1.subjects.index', ['university' => 99999]))
        ->assertStatus(422)
        ->assertJsonValidationErrors(['university']);
});

test('it validates program parameter must be an integer', function (): void {
    $this->withApiKey()
        ->getJson(route('api.v1.subjects.index', ['program' => 'invalid']))
        ->assertStatus(422)
        ->assertJsonValidationErrors(['program']);
});

test('it validates program parameter must exist', function (): void {
    $this->withApiKey()
        ->getJson(route('api.v1.subjects.index', ['program' => 99999]))
        ->assertStatus(422)
        ->assertJsonValidationErrors(['program']);
});

test('it validates semester parameter must be an integer', function (): void {
    $this->withApiKey()
        ->getJson(route('api.v1.subjects.index', ['semester' => 'invalid']))
        ->assertStatus(422)
        ->assertJsonValidationErrors(['semester']);
});

test('it validates semester parameter must be at least 1', function (): void {
    $this->withApiKey()
        ->getJson(route('api.v1.subjects.index', ['semester' => 0]))
        ->assertStatus(422)
        ->assertJsonValidationErrors(['semester']);
});

test('it validates page parameter must be an integer', function (): void {
    $this->withApiKey()
        ->getJson(route('api.v1.subjects.index', ['page' => 'invalid']))
        ->assertStatus(422)
        ->assertJsonValidationErrors(['page']);
});

test('it validates page parameter must be at least 1', function (): void {
    $this->withApiKey()
        ->getJson(route('api.v1.subjects.index', ['page' => 0]))
        ->assertStatus(422)
        ->assertJsonValidationErrors(['page']);
});

test('it can customize perPage parameter', function (): void {
    $university = University::factory()->create();
    $program = Program::factory()->create();
    Subject::factory()->count(15)->create([
        'university_id' => $university->id,
        'program_id' => $program->id,
    ]);

    $this->withApiKey()
        ->getJson(route('api.v1.subjects.index', ['perPage' => 10]))
        ->assertSuccessful()
        ->assertJson([
            'status' => 'success',
            'error' => false,
        ])
        ->assertJsonCount(10, 'data');
});

test('it uses default perPage of 20 when not specified', function (): void {
    $university = University::factory()->create();
    $program = Program::factory()->create();
    Subject::factory()->count(25)->create([
        'university_id' => $university->id,
        'program_id' => $program->id,
    ]);

    $this->withApiKey()
        ->getJson(route('api.v1.subjects.index'))
        ->assertSuccessful()
        ->assertJson([
            'status' => 'success',
            'error' => false,
        ])
        ->assertJsonCount(20, 'data');
});

test('it validates perPage parameter must be an integer', function (): void {
    $this->withApiKey()
        ->getJson(route('api.v1.subjects.index', ['perPage' => 'invalid']))
        ->assertStatus(422)
        ->assertJsonValidationErrors(['perPage']);
});

test('it validates perPage parameter must be at least 1', function (): void {
    $this->withApiKey()
        ->getJson(route('api.v1.subjects.index', ['perPage' => 0]))
        ->assertStatus(422)
        ->assertJsonValidationErrors(['perPage']);
});

test('it validates perPage parameter must not exceed 100', function (): void {
    $this->withApiKey()
        ->getJson(route('api.v1.subjects.index', ['perPage' => 101]))
        ->assertStatus(422)
        ->assertJsonValidationErrors(['perPage']);
});
