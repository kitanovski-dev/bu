<?php

namespace App\Src\Domain\Services\Auth;

use Illuminate\Support\Facades\Log;
use App\App\Domain\Payloads\ErrorPayload;
use App\App\Domain\Payloads\ServiceInterface;
use App\App\Domain\Payloads\SuccessPayload;
use App\App\Domain\Payloads\ValidationPayload;
use App\Src\Domain\Repositories\Eloquent\EloquentUserRepository;

class RegisterUserService implements ServiceInterface
{
    protected $users;

    public function __construct(EloquentUserRepository $users)
    {
        $this->users = $users;
    }

    public function handle($data = [])
    {
        if(($validator = $this->validate($data))->fails()) {
            return new ValidationPayload($validator->getMessageBag());
        }

        unset($data['password_confirmation']);

        try {
            $user = $this->users->create($data);
        } catch (\Exception $e) {
            Log::error($e->getMessage(), ['auth_user_id' => null]);

            return new ErrorPayload(['message' => 'resource_not_created',], 417);
        }
        
        unset($user['id']);

        return new SuccessPayload($user);
    }

    protected function validate($data)
    {
        return validator($data, [
            'email'      => 'required|email|max:254|unique:users,email',
            'username'   => 'max:254|unique:users,username',
            'first_name' => 'required|string|max:254',
            'last_name'  => 'required|string|max:254',
            'password'   => 'min:3|max:30|confirmed',
        ]);
    }
}
