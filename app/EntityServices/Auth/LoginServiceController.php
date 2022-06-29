<?php

namespace App\EntityServices\Auth;

use App\Helpers\Statuses\HTTPResponseStatuses;
use App\Http\Requests\Auth\AuthorizeRequest;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\JsonResponse;
use Laravel\Passport\Client;
use Psr\Http\Message\StreamInterface;

class LoginServiceController
{
    /**
     * @param AuthorizeRequest $request
     * @return JsonResponse|StreamInterface
     * @throws GuzzleException
     */
    public function signIn(AuthorizeRequest $request)
    {
        $http = new \GuzzleHttp\Client;

        $passwordGrantClient = Client::where('password_client', true)->first();

        try {
            $response = $http->post(route('passport.token'), [
                'form_params' => [
                    'grant_type' => 'password',
                    'client_id' => $passwordGrantClient->id,
                    'client_secret' => $passwordGrantClient->secret,
                    'username' => $request->email,
                    'password' => $request->password,
                    'scope' => ''
                ]
            ]);

            return $response->getBody();
        } catch (BadResponseException $e) {
            if ($e->getCode() === HTTPResponseStatuses::BAD_REQUEST) {
                return response()->json('Invalid Request', $e->getCode());
            } else if ($e->getCode() === HTTPResponseStatuses::UNAUTHORIZED) {
                return response()->json('Your credentials are incorrect', $e->getCode());
            }

            return response()->json('Something went wrong on the server', $e->getCode());
        }
    }

    public function logout(): JsonResponse
    {
        auth()->user()->token()->revoke();

        return response()->json(['message' => 'You successfully logged out']);
    }
}
