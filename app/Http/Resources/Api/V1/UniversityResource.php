<?php

namespace App\Http\Resources\Api\V1;

use App\Models\University;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin University */
class UniversityResource extends JsonResource
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
            'university_id' => $this->id,
            'name' => $this->name,
            'label' => $this->label,
        ];
    }
}
