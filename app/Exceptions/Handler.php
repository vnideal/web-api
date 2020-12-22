<?php

namespace App\Exceptions;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
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
        $notFound = ['message' => 'Resource not found'];

        $this->renderable(function (ModelNotFoundException $e, $request) use ($notFound) {
            return response()->json($notFound, 404);
        });

        $this->renderable(function (NotFoundHttpException $exception, $request) use ($notFound) {
            return response()->json($notFound, 404);
        });
    }
}
