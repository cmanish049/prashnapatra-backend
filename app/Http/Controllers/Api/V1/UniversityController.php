<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\UniversityResource;
use App\Models\University;
use Illuminate\Http\JsonResponse;

class UniversityController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'error' => false,
            'data' => UniversityResource::collection(University::all()),
        ]);
    }
}
