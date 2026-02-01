<?php

use App\Http\Controllers\Api\V1\ProgramController;
use App\Http\Controllers\Api\V1\ShowSubjectController;
use App\Http\Controllers\Api\V1\SubjectController;
use App\Http\Controllers\Api\V1\UniversityController;

Route::prefix('v1')->as('api.v1.')
    ->middleware(['api.key', 'gzip'])
    ->group(function (): void {
        Route::get('universities', UniversityController::class)
            ->name('universities.index');
        Route::get('universities/{universityId}/programs', [ProgramController::class, 'index'])
            ->name('universities.programs.index');
        Route::get('subjects', SubjectController::class)
            ->name('subjects.index');
        Route::get('subjects/{subjectId}', ShowSubjectController::class)
            ->name('subjects.show');
    });
