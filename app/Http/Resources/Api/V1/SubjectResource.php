<?php

namespace App\Http\Resources\Api\V1;

use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Subject */
class SubjectResource extends JsonResource
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
            'subject_id' => $this->id,
            'name' => $this->name,
            'code' => $this->code,
            'description' => $this->description,
            'semester' => $this->semester,
            'credit' => $this->credit,
            'syllabus_url' => $this->syllabus_url,
            'university' => new UniversityResource($this->whenLoaded('university')),
            'program' => new ProgramResource($this->whenLoaded('program')),
        ];
    }
}
