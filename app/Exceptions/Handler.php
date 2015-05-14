<?php namespace SeIT\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

/**
 * Class Handler
 * @package SeIT\Exceptions
 */
class Handler extends ExceptionHandler
{

    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        'Symfony\Component\HttpKernel\Exception\HttpException'
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return mixed
     */
    public function report(Exception $exception)
    {
        return parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        if (config('app.debug')) {
            $whoops = new \Whoops\Run;

            if ($request->ajax()) {
                $whoops->pushHandler(new \Whoops\Handler\JsonResponseHandler);
            } else {
                $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
            }

            return response(
                $whoops->handleException($exception),
                $exception->getStatusCode(),
                $exception->getHeaders()
            );
        }

        return parent::render($request, $exception);
    }
}
