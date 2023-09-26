<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

trait HttpResponseModel
{
  protected function success(mixed $payload = null, string $message = 'success', int $code = 200)
  {
    $data = [
      'code' => $code,
      'message' => $message,
      'data' => $payload
    ];
    return $data;
  }

  protected function error(string $message = 'error', int $code = 500, mixed $payload = null, mixed $class = null, string $method = '')
  {
    $data = [
      'code' => $code,
      'message' => $message
    ];

    if ($payload) {
      Log::error($class, [
        'Message: ' . $payload->getMessage(),
        'Method: '  . $method,
        'On File: ' . $payload->getFile(),
        'On Line: ' . $payload->getLine()
      ]);
    }
    return $data;
  }
}