<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\ListSubjectsRequest;
use App\Http\Resources\Api\V1\SubjectResource;
use App\Models\Program;
use App\Models\Subject;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class SubjectController extends Controller
{
    /**
     * List all subjects with pagination and optional filters.
     */
    public function __invoke(ListSubjectsRequest $request): JsonResponse
    {
        $perPage = $request->input('perPage', 20);

        $subjects = Subject::query()
            ->with(['university', 'program'])
            ->when($request->filled('university'), function ($query) use ($request): void {
                $query->where('university_id', $request->input('university'));
            })
            ->when($request->filled('program'), function ($query) use ($request): void {
                $query->where('program_id', $request->input('program'));
            })
            ->when($request->filled('semester'), function ($query) use ($request): void {
                $query->where('semester', $request->input('semester'));
            })
            ->simplePaginate($perPage);

        return response()->json([
            'status' => 'success',
            'error' => false,
            'data' => SubjectResource::collection($subjects),
        ]);
    }
}
