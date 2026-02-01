<?php

use App\Http\Requests\Api\V1\ListSubjectsRequest;
use App\Models\Program;
use App\Models\University;
use Illuminate\Support\Facades\Validator;

describe('ListSubjectsRequest', function (): void {
    test('it authorizes the request', function (): void {
        $request = new ListSubjectsRequest();

        expect($request->authorize())->toBeTrue();
    });

    test('it passes validation with valid university parameter', function (): void {
        $university = University::factory()->create();

        $validator = Validator::make(
            ['university' => $university->id],
            new ListSubjectsRequest()->rules()
        );

        expect($validator->passes())->toBeTrue();
    });

    test('it fails validation when university is not an integer', function (): void {
        $validator = Validator::make(
            ['university' => 'invalid'],
            new ListSubjectsRequest()->rules()
        );

        expect($validator->fails())->toBeTrue();
        expect($validator->errors()->has('university'))->toBeTrue();
    });

    test('it fails validation when university does not exist', function (): void {
        $validator = Validator::make(
            ['university' => 99999],
            new ListSubjectsRequest()->rules()
        );

        expect($validator->fails())->toBeTrue();
        expect($validator->errors()->has('university'))->toBeTrue();
    });

    test('it passes validation with valid program parameter', function (): void {
        $program = Program::factory()->create();

        $validator = Validator::make(
            ['program' => $program->id],
            new ListSubjectsRequest()->rules()
        );

        expect($validator->passes())->toBeTrue();
    });

    test('it fails validation when program is not an integer', function (): void {
        $validator = Validator::make(
            ['program' => 'invalid'],
            new ListSubjectsRequest()->rules()
        );

        expect($validator->fails())->toBeTrue();
        expect($validator->errors()->has('program'))->toBeTrue();
    });

    test('it fails validation when program does not exist', function (): void {
        $validator = Validator::make(
            ['program' => 99999],
            new ListSubjectsRequest()->rules()
        );

        expect($validator->fails())->toBeTrue();
        expect($validator->errors()->has('program'))->toBeTrue();
    });

    test('it passes validation with valid semester parameter', function (): void {
        $validator = Validator::make(
            ['semester' => 3],
            new ListSubjectsRequest()->rules()
        );

        expect($validator->passes())->toBeTrue();
    });

    test('it fails validation when semester is not an integer', function (): void {
        $validator = Validator::make(
            ['semester' => 'invalid'],
            new ListSubjectsRequest()->rules()
        );

        expect($validator->fails())->toBeTrue();
        expect($validator->errors()->has('semester'))->toBeTrue();
    });

    test('it fails validation when semester is less than 1', function (): void {
        $validator = Validator::make(
            ['semester' => 0],
            new ListSubjectsRequest()->rules()
        );

        expect($validator->fails())->toBeTrue();
        expect($validator->errors()->has('semester'))->toBeTrue();
    });

    test('it passes validation with valid page parameter', function (): void {
        $validator = Validator::make(
            ['page' => 2],
            new ListSubjectsRequest()->rules()
        );

        expect($validator->passes())->toBeTrue();
    });

    test('it fails validation when page is not an integer', function (): void {
        $validator = Validator::make(
            ['page' => 'invalid'],
            new ListSubjectsRequest()->rules()
        );

        expect($validator->fails())->toBeTrue();
        expect($validator->errors()->has('page'))->toBeTrue();
    });

    test('it fails validation when page is less than 1', function (): void {
        $validator = Validator::make(
            ['page' => 0],
            new ListSubjectsRequest()->rules()
        );

        expect($validator->fails())->toBeTrue();
        expect($validator->errors()->has('page'))->toBeTrue();
    });

    test('it passes validation with valid perPage parameter', function (): void {
        $validator = Validator::make(
            ['perPage' => 50],
            new ListSubjectsRequest()->rules()
        );

        expect($validator->passes())->toBeTrue();
    });

    test('it fails validation when perPage is not an integer', function (): void {
        $validator = Validator::make(
            ['perPage' => 'invalid'],
            new ListSubjectsRequest()->rules()
        );

        expect($validator->fails())->toBeTrue();
        expect($validator->errors()->has('perPage'))->toBeTrue();
    });

    test('it fails validation when perPage is less than 1', function (): void {
        $validator = Validator::make(
            ['perPage' => 0],
            new ListSubjectsRequest()->rules()
        );

        expect($validator->fails())->toBeTrue();
        expect($validator->errors()->has('perPage'))->toBeTrue();
    });

    test('it fails validation when perPage exceeds 100', function (): void {
        $validator = Validator::make(
            ['perPage' => 101],
            new ListSubjectsRequest()->rules()
        );

        expect($validator->fails())->toBeTrue();
        expect($validator->errors()->has('perPage'))->toBeTrue();
    });

    test('it passes validation when all parameters are valid', function (): void {
        $university = University::factory()->create();
        $program = Program::factory()->create();

        $validator = Validator::make(
            [
                'university' => $university->id,
                'program' => $program->id,
                'semester' => 2,
                'page' => 1,
                'perPage' => 25,
            ],
            new ListSubjectsRequest()->rules()
        );

        expect($validator->passes())->toBeTrue();
    });

    test('it passes validation when all parameters are omitted', function (): void {
        $validator = Validator::make(
            [],
            new ListSubjectsRequest()->rules()
        );

        expect($validator->passes())->toBeTrue();
    });
});
