<?php

namespace App\Src\Domain\Services\Auth;

use Illuminate\Support\Facades\Auth;
use App\App\Domain\Payloads\SuccessPayload;
use App\App\Domain\Payloads\ServiceInterface;
use App\App\Domain\Payloads\ValidationPayload;
use App\App\Domain\Payloads\UnauthorizedPayload;
use App\App\Domain\Payloads\UnauthenticatedPayload;

class LoginUserService implements ServiceInterface
{
    public function handle($data = [])
    {
        if(($this->validate($data)->fails())) {
            return new ValidationPayload('Please enter valid data');
        }

        if(!auth()->attempt($data)) {
            return new UnauthorizedPayload('User not authorized');
        }
        
        if(!auth()->user()->email_verified_at) {
            return new UnauthenticatedPayload("User email not validated.");
        }
        
        $success['name']  = auth()->user()->first_name;
        $success['token'] = auth()->user()->createToken('FreeApi')->accessToken;
        return new SuccessPayload($success);
    }

    protected function validate($data)
    {
        return validator($data, [
            'email'    => 'required|exists:users,email',
            'password' => 'required|min:3|max:30'
        ]);
    }
}
