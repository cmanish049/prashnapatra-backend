<?php

use App\Http\Controllers\Api\V1\ListSubjectQuestionPapersController;
use App\Http\Controllers\Api\V1\ListSubjectsController;
use App\Http\Controllers\Api\V1\ListUniversitiesController;
use App\Http\Controllers\Api\V1\ListUniversityProgramsController;
use App\Http\Controllers\Api\V1\ShowSubjectController;
use Illuminate\Support\Facades\DB;

Route::get('health', function () {
    try {
        DB::connection()->getPdo();
        $dbStatus = true;
    } catch (\Throwable) {
        $dbStatus = false;
    }

    $status = $dbStatus ? 'healthy' : 'unhealthy';

    return response()->json([
        'status' => $status,
        'database' => $dbStatus,
    ], $dbStatus ? 200 : 503);
})->name('api.health');

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
