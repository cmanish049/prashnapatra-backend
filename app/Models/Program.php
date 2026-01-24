<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $name
 * @property string $abbreviation
 * @property Carbon $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 */
class Program extends Model
{
    use HasFactory;

    /*
     * @var list<string>
     */
    public $guarded = [];

    public function universities(): BelongsToMany
    {
        return $this->belongsToMany(
            University::class,
            'programs_universities'
        );
    }

    public function subjects(): HasMany
    {
        return $this->hasMany(Subject::class);
    }
}
