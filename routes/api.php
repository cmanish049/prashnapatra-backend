<?php

use App\Http\Controllers\Api\V1\ProgramController;
use App\Http\Controllers\Api\V1\UniversityController;

Route::prefix('v1')->group(function () {
    Route::get('universities', UniversityController::class);
    Route::get('universities/{universityId}/programs', [ProgramController::class, 'index']);
});
