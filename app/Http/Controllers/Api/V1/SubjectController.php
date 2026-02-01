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
    public function __invoke(): JsonResponse
    {
        $subjects = Subject::query()
            ->with(['university', 'program'])
            ->simplePaginate(20);

        return response()->json([
            'status' => 'success',
            'error' => false,
            'data' => SubjectResource::collection($subjects),
        ]);
    }
}
