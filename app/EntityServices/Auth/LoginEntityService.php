<?php

namespace App\EntityServices\Auth;

use App\Dto\Auth\AuthorizeDto;
use App\Dto\User\TokenDto;
use App\Exceptions\AuthErrorException;
use Tymon\JWTAuth\Facades\JWTAuth;

class LoginEntityService
{
    /**
     * @throws AuthErrorException
     */
    public function signIn(AuthorizeDto $dto): TokenDto
    {
        if (!$token = JWTAuth::attempt($dto->toArray())) {
            throw new AuthErrorException();
        }

        return TokenDto::fromToken($token);
    }

    public function refresh(): TokenDto
    {
        $token = JWTAuth::getToken();

        return TokenDto::fromToken(JWTAuth::refresh($token));
    }

    public function logout(): void
    {
        auth()->logout();
    }
}
