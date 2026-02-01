<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\SubjectResource;
use App\Models\Subject;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ShowSubjectController extends Controller
{
    /**
     * Get a specific subject by ID.
     */
    public function __invoke(int $subjectId): JsonResponse
    {
        $subject = Subject::query()
            ->with(['university', 'program'])
            ->find($subjectId);

        if (! $subject) {
            return response()->json([
                'status' => 'error',
                'error' => true,
                'message' => 'Subject not found',
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'status' => 'success',
            'error' => false,
            'data' => new SubjectResource($subject),
        ]);
    }
}
