<?php

namespace App\Dto\Auth;

use App\Dto\BaseDto;
use App\Http\Requests\Auth\RegisterRequest;
use Illuminate\Support\Facades\Hash;

class RegisterDto extends BaseDto
{
    public string $name;
    public string $email;
    public string $password;

    public static function fromRequest(RegisterRequest $request): self
    {
        return new self([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
        ]);
    }
}
