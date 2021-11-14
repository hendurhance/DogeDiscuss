<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
class Question extends Model
{
    use HasFactory;

    protected $table = 'questions';

    protected $fillable = [
        'title',
        'slug',
        'body',
        'category_id',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    // auto generate slug with title when a question is created, if slug is not unique then add a random string
    public static function boot()
    {
        parent::boot();

        static::creating(function ($question) {
            $question->slug = Str::slug($question->title);

            if (static::whereSlug($question->slug)->exists()) {
                $question->slug = $question->slug . '-' . Str::random(5);
            }
        });
    }

    public function getPathAttribute()
    {
        return asset("api/questions/$this->slug");
    }
}
