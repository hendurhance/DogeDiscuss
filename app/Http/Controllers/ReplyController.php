<?php

namespace App\Http\Controllers;

use App\Exceptions\ReplyNotBelongToQuestion;
use App\Http\Requests\ReplyRequest;
use App\Http\Requests\ReplyUpdate;
use App\Http\Resources\ReplyCollection;
use App\Http\Resources\ReplyResource;
use App\Models\Question;
use App\Models\Reply;
use App\Notifications\NewReplyNotification;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ReplyController extends Controller
{

    public function __construct()
    {
        $this->middleware('JWT', ['except' => ['index', 'show']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Question $question)
    {
        // return ReplyCollection latest replies and paginate
        return ReplyCollection::collection($question->replies()->latest()->paginate(5));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ReplyRequest $request, Question $question)
    {
        // create a new reply
        $reply = new Reply;
        $reply->body = $request->body;
        $reply->user_id = auth()->user()->id;
        $question->replies()->save($reply);

        // notify the question owner
        $user = $question->user;
        $user->notify(new NewReplyNotification($reply));

        return response([
            'data' => new ReplyResource($reply)
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Reply  $reply
     * @return \Illuminate\Http\Response
     */
    public function show(Question $question, Reply $reply)
    {
        return $reply;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Reply  $reply
     * @return \Illuminate\Http\Response
     */
    public function edit(Reply $reply)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Reply  $reply
     * @return \Illuminate\Http\Response
     */
    public function update(ReplyUpdate $request, Question $question, Reply $reply)
    {
        $check = $this->checkReply($question->id, $reply->question_id);
        
        if($check){
            $reply->update($request->only('body'));
            return response([
                'data' => new ReplyResource($reply)
            ], Response::HTTP_CREATED);
        }else{
            throw new ReplyNotBelongToQuestion;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Reply  $reply
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question, Reply $reply)
    {
        // check if user is authorized to delete the reply
        if (auth()->user()->id !== $reply->user_id) {
            return response([
                'error' => 'You are not authorized to delete this reply'
            ], Response::HTTP_UNAUTHORIZED);
        }


        $check = $this->checkReply($question->id, $reply->question_id);
        
        if($check){
            $reply->delete();
            return response(null, Response::HTTP_NO_CONTENT);
        }else{
            throw new ReplyNotBelongToQuestion;
        }
    }

    /**
     * Check if Reply belongs to question
     * @param $question_id
     * @param $reply_question_id
     * @return bool
     */
    public static function checkReply($question_id, $reply_question_id)
    {
        if ($question_id === $reply_question_id) {
            return true;
        }else{
            return false;
        }
    }
}
