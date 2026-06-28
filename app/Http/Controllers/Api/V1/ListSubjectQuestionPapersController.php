<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\SubjectQuestionPaperResource;
use App\Models\QuestionPaper;
use App\Models\Subject;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ListSubjectQuestionPapersController extends Controller
{
    /**
     * List all question papers for a subject with pagination.
     */
    public function __invoke(Request $request, int $subjectId): JsonResponse
    {
        $subject = Subject::find($subjectId);

        if (! $subject) {
            return response()->json([
                'status' => 'error',
                'error' => true,
                'message' => 'Subject not found',
            ], Response::HTTP_NOT_FOUND);
        }

        $perPage = $request->input('perPage', 20);

        $questionPapers = QuestionPaper::query()
            ->where('subject_id', $subjectId)
            ->orderBy('year', 'desc')
            ->simplePaginate($perPage);

        return response()->json([
            'status' => 'success',
            'error' => false,
            'data' => SubjectQuestionPaperResource::collection($questionPapers),
            'pagination' => [
                'count' => $questionPapers->count(),
                'per_page' => $questionPapers->perPage(),
                'current_page' => $questionPapers->currentPage(),
                'has_more_pages' => $questionPapers->hasMorePages(),
                'next_page_url' => $questionPapers->nextPageUrl(),
                'prev_page_url' => $questionPapers->previousPageUrl(),
            ],
        ]);
    }
}
