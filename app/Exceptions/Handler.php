<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Throwable;

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
     * Report or log an exception.
     *
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Throwable $exception)
    {
        // Reporting to Sentry
        $sentryLogEnabled = env('SENTRY_LOG_ENABLED', false);
        if ($sentryLogEnabled && app()->bound('sentry') && $this->shouldReport($exception)) {
            app('sentry')->captureException($exception);
        }

        parent::report($exception);
    }

    /**
     * Determine if the exception is in the "do not report" list.
     *
     * @param  \Throwable  $e
     * @return bool
     */
    protected function shouldntReport(Throwable $e)
    {
        // Note that default implementation excludes all HttpExceptions from report via internalDontReport list
        // lines below are added in order to allow reporting of all 5xx errors
        if ($this->isHttpException($e) && in_array($e->getStatusCode(), range(500, 599))) {
            return false;
        }

        return parent::shouldntReport($e);
    }

    protected function convertValidationExceptionToResponse(ValidationException $e, $request)
    {
        if ($request->expectsJson()) {
            $e = new RestValidationException($e->validator, $e->response, $e->errorBag);
        }

        return parent::convertValidationExceptionToResponse($e, $request);
    }
}
