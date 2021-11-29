<?php

namespace App\Src\Actions\V1\Auth;

use Illuminate\Http\Request;
use App\Src\Responders\Auth\LoginUserResponder;
use App\Src\Domain\Services\Auth\LoginUserService;

class LoginUserAction
{
    protected $service;

    protected $responder;

    public function __construct(LoginUserService $service, LoginUserResponder $responder)
    {
        $this->service = $service;
        $this->responder = $responder;
    }

    public function __invoke(Request $request)
    {
        $data = $this->service->handle(
            $request->only([
                'email',
                'password'
            ])
        );

        return $this->responder->withResponse($data)->respond();
    }
}
