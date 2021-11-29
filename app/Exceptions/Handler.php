<?php

namespace App\Exceptions;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Auth\AuthenticationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var string[]
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var string[]
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $e
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $e)
    {
        if($request->expectsJson()) {
            
            if($e instanceof ModelNotFoundException) {
                return response()->json([
                    'message' => 'Resource not found'
                ], 404);
            }
            if($e instanceof AuthenticationException) {
                return response()->json([
                    'message' => 'Unauthorized'
                ], 401);
            }
            if($e instanceof NotFoundHttpException) {
                return response()->json([
                    'message' => 'Route not found'
                ], 404);
            }
            if($e instanceof \Tymon\JWTAuth\Exceptions\JWTException) {
                return response()->json([
                    'message' => 'Unauthenticated'
                ], 401);
            }
            // Tymon\\JWTAuth\\Exceptions\\JWTException
        

        }

        return parent::render($request, $e);
    }
}
