<?php

namespace App\Exceptions;

use Exception;
use Symfony\Component\HttpFoundation\Response;

class ReplyLiked extends Exception
{
    //
    public function render($request)
    {
        if ($request->expectsJson()) {
            return response()->json([
                'error' => 'You already liked this reply.'
            ], Response::HTTP_FORBIDDEN);
        }


        return response()->json([
            'error' => 'You have already liked this reply'
        ], Response::HTTP_FORBIDDEN);
    }
}
