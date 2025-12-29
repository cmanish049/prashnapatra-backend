<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\Subject
 *
 * @property int $id
 * @property string $name
 * @property int $university_id
 * @property int $program_id
 * @property int $semester
 * @property int $credit
 * @property string $code
 * @property string $syllabus_url
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 */
class Subject extends Model
{
    use HasFactory;

    /*
     * @var list<string>
     */
    protected $guarded = [];

    public function university(): BelongsTo
    {
        return $this->belongsTo(University::class);
    }

    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class);
    }
}
