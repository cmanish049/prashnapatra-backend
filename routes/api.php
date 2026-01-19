<?php

use App\Http\Controllers\Api\V1\ProgramController;
use App\Http\Controllers\Api\V1\UniversityController;

Route::prefix('v1')->as('api.v1.')->group(function () {
    Route::get('universities', UniversityController::class)
        ->name('universities.index');
    Route::get('universities/{universityId}/programs', [ProgramController::class, 'index'])
        ->name('universities.programs.index');
});
