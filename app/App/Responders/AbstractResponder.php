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
        if (
            $response instanceof ValidationPayload ||
            $response instanceof ErrorPayload ||
            $response instanceof UnauthorizedPayload
        ) {
            return true;
        }

        return false;
    }
}
