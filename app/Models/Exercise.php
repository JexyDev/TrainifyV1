<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exercise extends Model
{
    use HasFactory;

    protected $fillable = [
        'workout_id',
        'name',
        'sets',
        'reps',
        'rest_seconds',
        'order',
    ];

    protected $casts = [
        'sets' => 'integer',
        'rest_seconds' => 'integer',
        'order' => 'integer',
    ];

    /**
     * Get the workout that owns the exercise.
     */
    public function workout()
    {
        return $this->belongsTo(Workout::class);
    }
}
