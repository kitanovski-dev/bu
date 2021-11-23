<?php

namespace App\App\Domain\Payloads;

use App\App\Domain\Payloads\Payload;

class ErrorPayload extends Payload
{
    protected $status = 400;

    public function getData()
    {
        return [
            'status' => "error",
            'type' => 'general_error',
            'code' => $this->status,
            'messages' => $this->data,
            'data' => []
        ];
    }
}
