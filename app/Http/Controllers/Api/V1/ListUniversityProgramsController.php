<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\ProgramResource;
use App\Models\University;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ListUniversityProgramsController extends Controller
{
    /**
     * List programs for a specific university.
     */
    public function __invoke(int $universityId): JsonResponse
    {
        $university = University::query()->find($universityId);

        if (! $university) {
            return response()->json([
                'status' => 'error',
                'error' => true,
                'message' => 'University not found',
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'status' => 'success',
            'error' => false,
            'data' => ProgramResource::collection($university->programs),
        ]);
    }
}