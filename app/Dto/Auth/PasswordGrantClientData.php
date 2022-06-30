<?php

namespace App\Dto\Auth;

use App\Dto\BaseObjectData;
use Laravel\Passport\Client;

class PasswordGrantClientData extends BaseObjectData
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
