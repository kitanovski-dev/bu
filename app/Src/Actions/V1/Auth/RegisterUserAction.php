<?php

namespace App\Src\Actions\V1\Auth;

use App\Src\Domain\Services\Auth\RegisterUserService;
use App\Src\Responders\Auth\RegisterUserResponder;
use Illuminate\Http\Request;

class RegisterUserAction
{
    protected $service;

    protected $responder;

    public function __construct(RegisterUserService $service,RegisterUserResponder $responder)
    {
        $this->service = $service;
        $this->responder = $responder;
    }

    public function __invoke(Request $request)
    {

        $data = $this->service->handle(
                $request->only([
                    'email',
                    'username',
                    'first_name',
                    'last_name',
                    'password',
                    'password_confirmation'
                ]),
        );

        return $this->responder->withResponse($data)->respond();
    }
}
