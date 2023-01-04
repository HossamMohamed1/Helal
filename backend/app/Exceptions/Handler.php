<?php

namespace App\Exceptions;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
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

    public function render($request, Throwable $exception)
    {
        if ($exception instanceof GeneralException && $request->expectsJson()) {
            dd($exception);
            return response()->json([
                'message' => $exception,
                'code' => 404
            ], 404);
        }

        if ($exception instanceof ChartTypeException && $request->expectsJson()) {
            return response()->json([
                'message' => "Incorrect Type Of Chart",
                'code' => 400
            ], 400);
        }

        if ($exception instanceof ChartNotDefined && $request->expectsJson()) {
            return response()->json([
                'message' => "Chart Not Found",
                'code' => 404
            ], 404);
        }


        return parent::render($request, $exception);
    }

}
