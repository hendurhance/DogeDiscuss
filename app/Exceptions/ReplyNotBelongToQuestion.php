<?php

namespace App\Exceptions;

use Exception;
use Symfony\Component\HttpFoundation\Response;

class ReplyNotBelongToQuestion extends Exception
{
    //

    public function render($request)
    {
        if ($request->expectsJson()) {
            return response([
                'error' => 'Reply does not belong to question'
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return response()->json([
            'error' => 'Reply does not belong to question'
        ], Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
