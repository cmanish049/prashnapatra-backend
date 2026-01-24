<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\SubjectResource;
use App\Models\Program;
use App\Models\Subject;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class SubjectController extends Controller
{
    /**
     * List all subjects with pagination.
     */
    public function all(): AnonymousResourceCollection
    {
        $subjects = Subject::query()
            ->with(['university', 'program'])
            ->simplePaginate(20);

        return SubjectResource::collection($subjects);
    }

    /**
     * List subjects for a specific program.
     */
    public function index(int $programId): JsonResponse
    {
        $program = Program::query()->find($programId);

        if (! $program) {
            return response()->json([
                'status' => 'error',
                'error' => true,
                'message' => 'Program not found',
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'error' => false,
            'data' => SubjectResource::collection($program->subjects),
        ]);
    }
}
