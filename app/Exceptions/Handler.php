<?php

namespace App\Exceptions;

use App\Exceptions\Controllers\Api\InvalidFormatException;
use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

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
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
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
        if ($exception instanceof InvalidFormatException) {
            return response()->json(['error' => $exception->getMessage()], $exception->getCode());
        } elseif ($exception instanceof InvalidArgumentException) {
            return response()->json(['error' => $exception->getMessage()], $exception->getCode());
        } elseif ($exception instanceof RequestException) {
            return response()->json(['error' => 'External API call failed.'], 500);
        } /*elseif ($exception instanceof Exception) {
            return response()->json(['error' => $exception->getMessage()], $exception->getCode());
        }*/

        return parent::render($request, $exception);
    }
}
