<?php

namespace App\App\Domain\Payloads;

use App\App\Domain\Payloads\Payload;

class UnauthorizedPayload extends Payload
{
    protected $status = 401;

    public function getData()
    {
        $responseData  = [
            'status'  => "error",
            'type'    => 'unauthorized_error',
            'code'    => $this->status,
            'message' => $this->data,
        ];

        return $responseData;
    }
}
