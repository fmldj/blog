<?php

namespace App\Exceptions;

use Exception;

class EmptyException extends Exception
{
    public function __construct($message = "", $code = 0)
    {
    	parent::__construct($message, $code);
    }

    public function render()
    {
    	return response()->json(['code' => $this->code, 'mesage' => $this->message], $this->code);
    }
}
