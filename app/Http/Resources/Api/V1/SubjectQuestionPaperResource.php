<?php

namespace App\Http\Resources\Api\V1;

use App\Models\QuestionPaper;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin QuestionPaper */
class SubjectQuestionPaperResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    #[\Override]
    public function toArray(Request $request): array
    {
        return [
            'question_paper_id' => $this->id,
            'subject_id' => $this->subject_id,
            'year' => $this->year,
            'file_path' => $this->file_path,
            'file_url' => $this->file_url,
        ];
    }
}
