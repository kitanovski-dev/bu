<?php

namespace App\App\Domain\Payloads;

use App\App\Domain\Payloads\Payload;

class UnauthenticatedPayload extends Payload
{
    protected $status = 401;

    public function getData()
    {
        $responseData  = [
            'status'  => "error",
            'type'    => 'unauthenticated_error',
            'code'    => $this->status,
            'message' => $this->data,
        ];

        return $responseData;
    }
}
