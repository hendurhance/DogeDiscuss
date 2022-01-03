<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Views extends Model
{
    use HasFactory;

    protected $fillable = [
        'question_id',
        'traffic_source',
        'ip_address',
        'user_agent',
    ];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
    
    

}
