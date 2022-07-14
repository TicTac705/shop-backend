<?php
namespace App\Dto\User;

use App\Dto\BaseDto;

class TokenDto extends BaseDto
{
    public string $access_token;
    public string $token_type = 'bearer';
    public int $expires_in;

    public static function fromToken(string $token): self
    {
        return new self([
            'access_token' => $token,
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }
}
