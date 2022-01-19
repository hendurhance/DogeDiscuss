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

    // auto generate slug from title when a user update a question
    public function save(array $options = [])
    {
        $this->slug = Str::slug($this->title);

        if (static::whereSlug($this->slug)->exists()) {
            $this->slug = $this->slug . '-' . Str::random(5);
        }

        parent::save($options);
    }


    public function getPathAttribute()
    {
        return asset("api/questions/$this->slug");
    }

    public function views()
    {
        return $this->hasMany(Views::class);
    }

    // return views count
    public function getViewsCountAttribute()
    {
        return $this->views()->count();
    }

    /**
     * Relationship between question and votes
     */
    public function votes()
    {
        return $this->hasMany(Vote::class);
    }

    /**
     * User can vote on a question
     */
    public function vote()
    {
        return $this->hasOne(Vote::class);
    }

    /**
     * When upVote is called on a question, it will create a new vote and store up in vote column, 
     */
    public function upVote()
    {
        // create or update vote
        $vote = $this->vote()->updateOrCreate(
            [
                'user_id' => auth()->id()
            ],
            [
                'vote' => 'up'
            ]
        );

        return $vote;
    }

    /**
     * When downVote is called on a question, it will update the vote column to down
     */
    public function downVote()
    {
        $vote = $this->vote()->updateOrCreate([
            'user_id' => auth()->id(),
        ], [
            'vote' => 'down',
        ]);

        return $vote;
    }

    /**
     * When resetVote is called on a question, it will delete the vote if it exists
     */
    public function resetVote()
    {
        // delete vote of the user
        $vote = $this->vote()->where('user_id', auth()->id());
        if ($vote) {
            $vote->delete();
        }

        return $vote;
    }

    /**
     * Return the vote status of the user
     */
    public function getVoteStatusAttribute()
    {
        if (auth()->guest()) {
            return null;
        }

        $vote = $this->vote()->where('user_id', auth()->id())->first();

        return $vote ? $vote->vote : null;
    }

    /**
     * Return all votes count
     * @return int
     */
    public function getVotesCountAttribute()
    {
        return $this->votes()->sum('vote');
    }

    /**
     * Return questions upvotes count
     */
    public function getUpvotesCountAttribute()
    {
        return $this->votes()->where('vote', 'up')->count();
    }

    /**
     * Return questions downvotes count
     */
    public function getDownvotesCountAttribute()
    {
        return $this->votes()->where('vote', 'down')->count();
    }

}
