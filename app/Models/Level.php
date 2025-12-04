<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Level extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($level) {
            if (empty($level->slug)) {
                $level->slug = Str::slug($level->name);
            }
        });

        static::updating(function ($level) {
            if ($level->isDirty('name')) {
                $level->slug = Str::slug($level->name);
            }
        });
    }

    /**
     * Get the workouts for the level.
     */
    public function workouts()
    {
        return $this->hasMany(Workout::class);
    }
}
