<?php

use App\Models\Program;
use App\Models\QuestionPaper;
use App\Models\Subject;
use App\Models\University;

test('it returns empty list when subject has no question papers', function (): void {
    $subject = Subject::factory()->create();

    $this->withApiKey()
        ->getJson(route('api.v1.subjects.question-papers.index', ['subjectId' => $subject->id]))
        ->assertSuccessful()
        ->assertJson([
            'status' => 'success',
            'error' => false,
        ])
        ->assertJsonCount(0, 'data');
});

test('it can list question papers for a subject', function (): void {
    $university = University::factory()->create();
    $program = Program::factory()->create();
    $subject = Subject::factory()->create([
        'university_id' => $university->id,
        'program_id' => $program->id,
    ]);

    $questionPaper = QuestionPaper::factory()->create([
        'subject_id' => $subject->id,
        'university_id' => $university->id,
        'program_id' => $program->id,
        'year' => 2023,
        'semester' => 3,
    ]);

    $this->withApiKey()
        ->getJson(route('api.v1.subjects.question-papers.index', ['subjectId' => $subject->id]))
        ->assertSuccessful()
        ->assertJson([
            'status' => 'success',
            'error' => false,
        ])
        ->assertJsonCount(1, 'data')
        ->assertJsonFragment([
            'question_paper_id' => $questionPaper->id,
            'subject_id' => $subject->id,
            'year' => 2023,
        ]);
});

test('it returns 404 when subject does not exist', function (): void {
    $this->withApiKey()
        ->getJson(route('api.v1.subjects.question-papers.index', ['subjectId' => 99999]))
        ->assertStatus(404)
        ->assertJson([
            'status' => 'error',
            'error' => true,
            'message' => 'Subject not found',
        ]);
});

test('it paginates question papers at 20 per page', function (): void {
    $subject = Subject::factory()->create();

    QuestionPaper::factory()->count(25)->create([
        'subject_id' => $subject->id,
    ]);

    $this->withApiKey()
        ->getJson(route('api.v1.subjects.question-papers.index', ['subjectId' => $subject->id]))
        ->assertSuccessful()
        ->assertJson([
            'status' => 'success',
            'error' => false,
        ])
        ->assertJsonCount(20, 'data');
});

test('it can customize perPage parameter', function (): void {
    $subject = Subject::factory()->create();

    QuestionPaper::factory()->count(15)->create([
        'subject_id' => $subject->id,
    ]);

    $this->withApiKey()
        ->getJson(route('api.v1.subjects.question-papers.index', [
            'subjectId' => $subject->id,
            'perPage' => 10,
        ]))
        ->assertSuccessful()
        ->assertJson([
            'status' => 'success',
            'error' => false,
        ])
        ->assertJsonCount(10, 'data');
});

test('it orders question papers by year descending', function (): void {
    $subject = Subject::factory()->create();

    $paper2020 = QuestionPaper::factory()->create([
        'subject_id' => $subject->id,
        'year' => 2020,
    ]);
    $paper2023 = QuestionPaper::factory()->create([
        'subject_id' => $subject->id,
        'year' => 2023,
    ]);
    $paper2021 = QuestionPaper::factory()->create([
        'subject_id' => $subject->id,
        'year' => 2021,
    ]);

    $response = $this->withApiKey()
        ->getJson(route('api.v1.subjects.question-papers.index', ['subjectId' => $subject->id]))
        ->assertSuccessful();

    $data = $response->json('data');

    expect($data[0]['year'])->toBe(2023)
        ->and($data[1]['year'])->toBe(2021)
        ->and($data[2]['year'])->toBe(2020);
});

test('it only returns question papers for the specified subject', function (): void {
    $subject1 = Subject::factory()->create();
    $subject2 = Subject::factory()->create();

    QuestionPaper::factory()->count(3)->create([
        'subject_id' => $subject1->id,
    ]);
    QuestionPaper::factory()->count(2)->create([
        'subject_id' => $subject2->id,
    ]);

    $this->withApiKey()
        ->getJson(route('api.v1.subjects.question-papers.index', ['subjectId' => $subject1->id]))
        ->assertSuccessful()
        ->assertJsonCount(3, 'data');
});

test('it requires authentication', function (): void {
    $subject = Subject::factory()->create();

    $this->getJson(route('api.v1.subjects.question-papers.index', ['subjectId' => $subject->id]))
        ->assertStatus(401);
});
