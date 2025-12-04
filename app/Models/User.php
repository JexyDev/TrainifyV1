<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'bio',
        'height',
        'weight',
        'age',
        'avatar',
        'specialization',
        'certifications',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'height' => 'integer',
            'weight' => 'integer',
            'age' => 'integer',
        ];
    }

    /**
     * Check if user is admin.
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user is trainer.
     */
    public function isTrainer()
    {
        return $this->role === 'trainer';
    }

    /**
     * Check if user is regular user.
     */
    public function isUser()
    {
        return $this->role === 'user';
    }

    /**
     * Get the workouts created by the trainer.
     */
    public function workouts()
    {
        return $this->hasMany(Workout::class, 'trainer_id');
    }

    /**
     * Get the user's workout progress.
     */
    public function workoutProgress()
    {
        return $this->hasMany(UserWorkoutProgress::class);
    }

    /**
     * Get the user's completed workouts.
     */
    public function completedWorkouts()
    {
        return $this->belongsToMany(Workout::class, 'user_workout_progress')
                    ->withPivot('completed_at', 'calories_burned', 'notes')
                    ->withTimestamps();
    }
}
