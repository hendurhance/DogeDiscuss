<?php

namespace App\Http\Controllers;

use App\Events\VoteEvent;
use App\Http\Requests\QuestionRequest;
use App\Http\Requests\QuestionUpdate;
use App\Models\Question;
use Illuminate\Http\Request;
use App\Http\Resources\QuestionCollection;
use App\Http\Resources\QuestionResource;
use App\Models\Category;
use Symfony\Component\HttpFoundation\Response;

class QuestionController extends Controller
{

    public function __construct()
    {
        $this->middleware('JWT', ['except' => ['index', 'show']]);
        $this->middleware('pagevisit', ['only' => ['show']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return QuestionCollection::collection(Question::latest()->paginate(20));
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
    public function store(QuestionRequest $request)
    {
        $question = new Question;
        $question->title = $request->title;
        $question->body = $request->body;
        $question->category_id = $request->category_id;
        $question->user_id = auth()->user()->id;
        $question->save();

        return response([
            'data' => new QuestionResource($question)
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function show(Question $question)
    {
        return new QuestionResource($question);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function edit(Question $question)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function update(QuestionUpdate $request, Question $question)
    {
        $question->update($request->all());
        return response([
            'data' => new QuestionResource($question)
        ], Response::HTTP_ACCEPTED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question)
    {
        // check if user is authorized to delete the question
        if (auth()->user()->id !== $question->user_id) {
            return response([
                'error' => 'You are not authorized to delete this question'
            ], Response::HTTP_UNAUTHORIZED);
        }



        $question->delete();
        return response(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * Upvote a question.
     */
    public function upVote(Question $question)
    {
        // if vote exist with same question_id and user_id and vote is up
        // then return error
        // else create new vote
        $vote = $question->votes()->where('user_id', auth()->id())->first();

        // if votes exits and vote is up
        if ($vote && $vote->vote == 'up') {
            return response()->json([
                'error' => 'You have already upvoted this question'
            ], Response::HTTP_BAD_REQUEST);
        }

        $question->upVote();
        broadcast(new VoteEvent($question->slug, 'up'))->toOthers();
        return response([
            'success' => 'You have up voted this question',
            'properties' => [
                'vote_count' => $question->votes()->count() ?? 0,
                'up_votes' => $question->votes()->where('vote', 'up')->count() ?? 0,
                'down_votes' => $question->votes()->where('vote', 'down')->count() ?? 0,
                'user_vote' => $question->votes()->where('user_id', auth()->id())->first()->vote ?? null
            ],
        ], Response::HTTP_OK);
    }

    /**
     * Downvote a question.
     */
    public function downVote(Question $question)
    {
        // if vote exist with same question_id and user_id and vote is down
        // then return error
        // else create new vote
        $vote = $question->votes()->where('user_id', auth()->id())->first();

        // if votes exits and vote is down
        if ($vote && $vote->vote == 'down') {
            return response()->json([
                'error' => 'You have already downvoted this question'
            ], Response::HTTP_BAD_REQUEST);
        }

        $question->downVote();
        broadcast(new VoteEvent($question->slug, 'down'))->toOthers();
        return response([
            'success' => 'You have down voted this question',
            'properties' => [
                'vote_count' => $question->votes()->count() ?? 0,
                'up_votes' => $question->votes()->where('vote', 'up')->count() ?? 0,
                'down_votes' => $question->votes()->where('vote', 'down')->count() ?? 0,
                'user_vote' => $question->votes()->where('user_id', auth()->id())->first()->vote ?? null
            ],
        ], Response::HTTP_OK);
    }

    /**
     * Reset vote of a question.
     */
    public function resetVote(Question $question)
    {
        // if vote exist with same question_id and user_id and vote is up
        // then return error
        // else create new vote
        $vote = $question->votes()->where('user_id', auth()->id())->first();

        // if votes exits delete vote
        if ($vote) {
            $question->resetVote();
            broadcast(new VoteEvent($question->slug, 'reset'))->toOthers();
            return response([
                'success' => 'You have reset your vote',
                'properties' => [
                    'vote_count' => $question->votes()->count() ?? 0,
                    'up_votes' => $question->votes()->where('vote', 'up')->count() ?? 0,
                    'down_votes' => $question->votes()->where('vote', 'down')->count() ?? 0,
                    'user_vote' => $question->votes()->where('user_id', auth()->id())->first()->vote ?? null
                ],
            ], Response::HTTP_OK);
        }

        return response([
            'error' => 'You have not voted this question'
        ], Response::HTTP_BAD_REQUEST);
    }
}
