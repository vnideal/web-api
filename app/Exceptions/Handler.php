<?php

namespace App\Exceptions;

use App\Traits\ApiResponser;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    use ApiResponser;
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
        $notFoundMsg = 'Resource not found';

        $this->renderable(function (ModelNotFoundException $e, $request) use ($notFoundMsg) {
            return $this->error($notFoundMsg, 404);
        });

        $this->renderable(function (NotFoundHttpException $e, $request) use ($notFoundMsg) {
            return $this->error($notFoundMsg, 404);
        });

        $this->renderable(function (MethodNotAllowedHttpException $e, $request) use ($notFoundMsg) {
            return $this->error($notFoundMsg, 404);
        });

        $this->renderable(function (ValidationException $e, $request) {
            return $this->error($e->getMessage(), 422, $e->errors());
        });

    }
}
