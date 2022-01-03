<?php

namespace App\Http\Middleware;

use App\Models\Views;
use App\Models\Question;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;
use Illuminate\Routing\Middleware\ThrottleRequests;
use Symfony\Component\HttpFoundation\Response;

class QuestionTraffic
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

    public function handle($request, Closure $next)
    {
        // get url
        $url = $request->url();
        // get the last part of url
        $url = explode('/', $url);
        $slug = end($url);
        // find the question with slug
        $question = Question::where('slug', $slug)->first();

        if ($question) {
            // if the same ip has already viewed the question
            if (Views::where('ip_address', $request->ip())->where('question_id', $question->id)->first()) {
                return $next($request);
            } else {
                $views = new Views;
                $views->question_id = $question->id;
                $views->traffic_source = $request->header('referer') ? $request->header('referer') : 'direct';
                $views->ip_address = $request->ip();
                $views->user_agent = $request->header('user-agent');
                $views->save();

                return $next($request);
            }
            
        } else {
            return response([
                'message' => 'Question not found'
            ], Response::HTTP_NOT_FOUND);
        }


    }


}
