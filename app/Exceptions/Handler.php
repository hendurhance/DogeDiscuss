<?php

namespace App\Exceptions;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Auth\AuthenticationException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

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
                    'error' => 'Resource not found'
                ], Response::HTTP_NOT_FOUND);
            }
            if($e instanceof AuthenticationException) {
                return response()->json([
                    'error' => 'Unauthorized'
                ], Response::HTTP_UNAUTHORIZED);
            }
            if($e instanceof NotFoundHttpException) {
                return response()->json([
                    'error' => 'Route not found'
                ], Response::HTTP_NOT_FOUND);
            }
            // if($e instanceof JWTException) {
            //     return response()->json([
            //         'error' => 'Token is invalid'
            //     ], Response::HTTP_UNAUTHORIZED);
            // }
            if($e instanceof TokenExpiredException) {
                return response()->json([
                    'error' => 'Token is expired'
                ], Response::HTTP_UNAUTHORIZED);
            }
            if($e instanceof TokenBlacklistedException) {
                return response()->json([
                    'error' => 'Token can not be used, try to login again'
                ], Response::HTTP_UNAUTHORIZED);
            }
        
            if($e instanceof TokenInvalidException) {
                return response()->json([
                    'error' => 'Token is invalid'
                ], Response::HTTP_UNAUTHORIZED);
            }

        }

        return parent::render($request, $e);
    }
}
