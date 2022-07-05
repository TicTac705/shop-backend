<?php
namespace App\Dto\Auth;

use App\Dto\BaseDto;
use App\Http\Requests\Auth\AuthorizeRequest;

class AuthorizeDto extends BaseDto
{
    public string $email;
    public string $password;

    public static function fromRequest(AuthorizeRequest $request): self
    {
        return new self([
            'email' => $request->get('email'),
            'password' => $request->get('password'),
        ]);
    }
}
