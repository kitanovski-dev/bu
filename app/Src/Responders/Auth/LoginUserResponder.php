<?php

namespace App\Src\Responders\Auth;

use App\App\Responders\AbstractResponder;
use App\App\Responders\ResponderInterface;

class LoginUserResponder extends AbstractResponder implements ResponderInterface
{
    public function respond()
    {
        if($this->hasErrorsPayload($this->response)) {
            return response()->json($this->response->getData(), $this->response->getStatus());
        }

        $data = $this->response->getData();

        return $data;
    }
}
