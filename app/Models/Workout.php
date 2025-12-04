<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Workout extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'trainer_id',
        'category_id',
        'level_id',
        'title',
        'slug',
        'description',
        'duration',
        'image',
        'status',
    ];

    protected $casts = [
        'duration' => 'integer',
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($workout) {
            if (empty($workout->slug)) {
                $workout->slug = Str::slug($workout->title);
            }
        });

        static::updating(function ($workout) {
            if ($workout->isDirty('title')) {
                $workout->slug = Str::slug($workout->title);
            }
        });
    }

    /**
     * Get the trainer that owns the workout.
     */
    public function trainer()
    {
        return $this->belongsTo(User::class, 'trainer_id');
    }

    /**
     * Get the category that owns the workout.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the level that owns the workout.
     */
    public function level()
    {
        return $this->belongsTo(Level::class);
    }

    /**
     * Get the exercises for the workout.
     */
    public function exercises()
    {
        return $this->hasMany(Exercise::class)->orderBy('order');
    }

    /**
     * Get the user progress records for the workout.
     */
    public function userProgress()
    {
        return $this->hasMany(UserWorkoutProgress::class);
    }

    /**
     * Scope a query to only include approved workouts.
     */
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    /**
     * Scope a query to only include pending workouts.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }
}
