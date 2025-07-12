<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
     public function render($request, Throwable $exception)
    {
        if ($exception instanceof \Symfony\Component\Routing\Exception\RouteNotFoundException) {
            $responseArray = apiResponse("Failed", $exception, false, '', 401);
            return response()->json($responseArray, 401);
        } else if ($exception instanceof \Illuminate\Auth\AuthenticationException) {
            $responseArray = apiResponse("Failed", $exception, false, '', 401);
            return response()->json($responseArray, 401);
        } else if ($exception instanceof \Symfony\Component\HttpKernel\Exception\HttpException) {
            $responseArray = apiResponse("Failed", $exception, false, '', 404);
            return response()->json($responseArray, 404);
        } else if ($exception instanceof \Illuminate\Database\Eloquent\ModelNotFoundException) {
            $responseArray = apiResponse("Failed", $exception, false, '', 500);
            return response()->json($responseArray, 500);
        } else if ($exception instanceof \Illuminate\Session\TokenMismatchException) {
            $responseArray = apiResponse("Failed", $exception, false, '', 400);
            return response()->json($responseArray, 400);
        } else if ($exception instanceof \Illuminate\Validation\ValidationException) {
            $responseArray = apiResponse("Failed", $exception, false, '', 422);
            return response()->json($responseArray, 422);
        } else if ($exception instanceof \Illuminate\Database\QueryException) {
            $responseArray = apiResponse("Failed", $exception, false, '', 500);
            return response()->json($responseArray, 500);
        } else if ($exception instanceof \Exception) {
            $responseArray = apiResponse("Failed", $exception, false, '', 500);
            return response()->json($responseArray, 500);
        } else if ($exception instanceof \Illuminate\Auth\Access\AuthorizationException) {
            $responseArray = apiResponse("Failed", $exception, false, '', 403);
            return response()->json($responseArray, 403);
        }
        return parent::render($request, $exception);
    }
}
