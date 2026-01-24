<?php

namespace App\Http\Resources\Api\V1;

use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Program */
class ProgramResource extends JsonResource
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
            'program_id' => $this->id,
            'name' => $this->name,
            'abbreviation' => $this->abbreviation,
        ];
    }
}
