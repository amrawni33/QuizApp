<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Wildside\Userstamps\Userstamps;

class Quiz extends Model
{
    use HasFactory, Userstamps;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'code',
        'name',
        'quiz_time',
        'quiz_date',
    ];

    /**
     * Get all of the details for the quiz
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function details()
    {
        return $this->hasMany(QuizDetails::class, 'quiz_id', 'id');
    }

    /**
     * Get all of the details for the quiz
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function grade()
    {
        return $this->hasMany(Grade::class, 'quiz_id', 'id');
    }
}
