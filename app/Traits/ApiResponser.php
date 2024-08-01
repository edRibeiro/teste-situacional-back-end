<?php

namespace App\Traits;

use Illuminate\Http\Response;

use function Laravel\Prompts\error;

trait ApiResponser
{
    protected function errorResponse($message, $code)
    {
        return response()->json(["error" => Response::$statusTexts[$code], 'message' => $message, 'code' => $code], $code);
    }
}
