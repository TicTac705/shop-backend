<?php

namespace App\Dto\Auth;

use App\Dto\BaseDto;
use Laravel\Passport\Client;

class PasswordGrantClientDto extends BaseDto
{
    public string $id;
    public string $secret;

    public function formQuery(Client $passwordGrantClient): self
    {
        return new self([
            'id' => $passwordGrantClient->id,
            'secret' => $passwordGrantClient->secret
        ]);
    }
}
