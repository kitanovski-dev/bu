<?php

namespace App\App\Responders;

abstract class AbstractResponder
{
    protected $response;

    public function withResponse($response)
    {
        $this->response = $response;
        return $this;
    }

    public function hasErrorsPayload($response)
    {
        
    }
}
