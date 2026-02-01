<?php

use App\Http\Controllers\Api\V1\ListSubjectQuestionPapersController;
use App\Http\Controllers\Api\V1\ListSubjectsController;
use App\Http\Controllers\Api\V1\ListUniversitiesController;
use App\Http\Controllers\Api\V1\ListUniversityProgramsController;
use App\Http\Controllers\Api\V1\ProgramController;
use App\Http\Controllers\Api\V1\ShowSubjectController;

Route::prefix('v1')->as('api.v1.')
    ->middleware(['api.key', 'gzip'])
    ->group(function (): void {
        Route::get('universities', ListUniversitiesController::class)
            ->name('universities.index');
        Route::get('universities/{universityId}/programs', ListUniversityProgramsController::class)
            ->name('universities.programs.index');
        Route::get('subjects', ListSubjectsController::class)
            ->name('subjects.index');
        Route::get('subjects/{subjectId}', ShowSubjectController::class)
            ->name('subjects.show');
        Route::get('subjects/{subjectId}/question-papers', ListSubjectQuestionPapersController::class)
            ->name('subjects.question-papers.index');
    });
