<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserWorkoutProgress extends Model
{
    use HasFactory;

    protected $table = 'user_workout_progress';

    protected $fillable = [
        'user_id',
        'workout_id',
        'completed_at',
        'calories_burned',
        'notes',
    ];

    protected $casts = [
        'completed_at' => 'datetime',
        'calories_burned' => 'integer',
    ];

    /**
     * Get the user that owns the progress.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the workout that owns the progress.
     */
    public function workout()
    {
        return $this->belongsTo(Workout::class);
    }
}
