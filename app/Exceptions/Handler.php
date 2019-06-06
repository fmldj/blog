<?php

namespace App\Exceptions;

use Exception;
use ErrorException;
use InvalidArgumentException;
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
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {   
        // dd($exception);
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
    	if($exception instanceof NotFoundHttpException)
    	{	
    		$message = $exception->getMessage()?$exception->getMessage():'页面内容不存在';
    		$code = $exception->getCode()?$exception->getCode():404;
    		return response()->json(['code' => $code, 'message' => $message], $code);
    	}

    	if($exception instanceof InvalidArgumentException){
    		$message = $exception->getMessage()?$exception->getMessage():'无效参数';
    		$code = $exception->getCode()?$exception->getCode():404;
    		return response()->json(['code' => $code, 'message' => $message], $code);
    	}
    	// if($exception instanceof ErrorException){
    	// 	$message = $exception->getMessage()?$exception->getMessage():'错误参数';
    	// 	$code = $exception->getCode()?$exception->getCode():404;
    	// 	return response()->json(['code' => $code, 'message' => $message], $code);
    	// }

        return parent::render($request, $exception);
    }
}
