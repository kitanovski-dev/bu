<?php

namespace App\Src\Responders\Auth;

use App\App\Responders\AbstractResponder;
use App\App\Responders\ResponderInterface;

class RegisterUserResponder extends AbstractResponder implements ResponderInterface
{
    public function respond()
    {
        // to be implemented if hasErrorPayload 

        $data = $this->response->getData();

        return $data;
    }
}
