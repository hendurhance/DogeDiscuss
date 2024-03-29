<?php

namespace App\Http\Controllers;

use App\Events\LikeEvent;
use App\Exceptions\ReplyLiked;
use App\Models\Like;
use App\Models\Reply;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LikeController extends Controller
{

    public function __construct()
    {
        $this->middleware('JWT');
    }

    /**
     * Like a reply.
     * 
     */
    public function likeIt(Reply $reply)
    {
        $hasLiked = $this->hasLiked($reply);
        if($hasLiked) {
            throw new ReplyLiked;
        }else{
            $reply->likes()->create([
                'user_id' => auth()->id()
            ]);

            broadcast(new LikeEvent($reply->id, 1))->toOthers();

            return response([
                'message' => 'Reply liked.',
                'properties' => [
                    'like_count' => $reply->likes->count(),
                    'is_liked' => true
                ]

            ], Response::HTTP_OK);
        }
    }

    /**
     * Unlike a reply.
     * 
     */
    public function unLikeIt(Reply $reply)
    {
        $hasLiked = $this->hasLiked($reply);
        if($hasLiked) {
            $reply->likes()->where('user_id', auth()->id())->delete();

            broadcast(new LikeEvent($reply->id, 0))->toOthers();

            return response([
                'message' => 'You have unliked this reply.',
                'properties' => [
                    'like_count' => $reply->likes->count(),
                    'is_liked' => false
                ]
            ], Response::HTTP_OK);
        }else{
            return response([
                'error' => 'You have not liked this reply.'
            ], Response::HTTP_OK);
        }
    }

    /**
     * Check if the user has liked a reply.
     */
    public function hasLiked(Reply $reply)
    {
        $like = $reply->likes()->where('user_id', auth()->id())->first();
        return $like ? true : false;
    }

    
}
