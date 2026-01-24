<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\Program
 *
 * @property int $id
 * @property string $name
 * @property string $label
 * @property Carbon|null $created_at
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

    /**
     * @return BelongsToMany
     */
    public function universities(): BelongsToMany
    {
        return $this->belongsToMany(
            University::class,
            'programs_universities'
        );
    }

    /**
     * @return HasMany
     */
    public function subjects(): HasMany
    {
        return $this->hasMany(Subject::class);
    }
}
