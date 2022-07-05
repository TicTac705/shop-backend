<?php

namespace App\Services\Auth;

use App\Dto\Auth\AuthorizeDto;
use App\Dto\Auth\PasswordGrantClientDto;
use Laravel\Passport\Client;

class LoginService
{
    public static function createToken(AuthorizeDto $data): array
    {
        $options = [
            'grant_type' => 'password',
            'username' => $data->email,
            'password' => $data->password
        ];

        return self::getRequestResponse($options);
    }

    public static function refreshToken(string $refreshToken): array
    {
        $options = [
            'grant_type' => 'refresh_token',
            'refresh_token' => $refreshToken
        ];

        return self::getRequestResponse($options);
    }

    public static function getClient(): PasswordGrantClientDto
    {
        $passwordGrantClient = Client::where('password_client', true)->first();

        return PasswordGrantClientDto::formQuery($passwordGrantClient);
    }

    private function getRequestResponse(array $options): array
    {
        $http = new \GuzzleHttp\Client;

        $client = self::getClient();

        $defaultOptions = [
            'client_id' => $client->id,
            'client_secret' => $client->secret,
            'scope' => ''
        ];

        $response = $http->post(route('passport.token'), [
            'form_params' => array_merge($options, $defaultOptions)
        ]);

        return json_decode($response->getBody(), true);
    }
}
