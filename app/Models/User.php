<?php

namespace App\Models;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    // Rest omitted for brevity

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    /**
     * Encode the user's password.
     * 
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    /**
     * Relationship between user and votes
     * 
     */
    public function votes()
    {
        return $this->hasMany(Vote::class);
    }

    /**
     * User can vote on a question
     * 
     */
    public function voteQuestion(Question $question, $vote)
    {
        $vote = $this->votes()->updateOrCreate(
            ['user_id' => $this->id, 'question_id' => $question->id],
            ['vote' => $vote]
        );

        return $vote;
    }

}
