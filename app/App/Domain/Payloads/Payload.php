<?php

namespace App\App\Domain\Payloads;

class Payload
{
    protected $data;

    protected $status = 200;

    protected $messages = [];

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function getData()
    {
        $responseData = [
            'status'  => 'success',
            'type'    => 'general_sucess',
            'code'    => $this->status,
            'message' => $this->messages,
            'data'    => $this->data,
        ];

        return $responseData;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function getMessage()
    {
        return $this->messages;
    }

    public function getMainData()
    {
        return $this->data;
    }
}
