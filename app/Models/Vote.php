<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    use HasFactory;

    protected $table = 'votes';

    protected $fillable = [
        'user_id',
        'question_id',
        'vote',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    /**
     * Vote can only be up or down
     */
    public function setVoteAttribute($value)
    {
        $this->attributes['vote'] = $value === 'up' ? 'up' : 'down';
    }
    
}
