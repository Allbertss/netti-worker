<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class NettiAPI
{
    public function __construct(
        private HttpClientInterface $client,
        private string              $oauthUrl,
        private string              $oauthEmail,
        private string              $oauthPassword,
        private string              $oauthGrantType
    )
    {
        $this->authenticate();
    }

    public function authenticate(): string
    {
        $response = $this->client->request(
            'POST',
            $this->oauthUrl,
            [
                'headers' => [
                    'Content-Type' => 'application/x-www-form-urlencoded',
                    'accept' => 'application/json',
                ],
                'body' => [
                    'username' => $this->oauthEmail,
                    'password' => $this->oauthPassword,
                    'email' => $this->oauthEmail,
                    'grant_type' => $this->oauthGrantType,
                ],
            ]
        );

        $access_token = ($response->toArray())['access_token'];
        $expires_in = ($response->toArray())['expires_in'];
        $token_type = ($response->toArray())['token_type'];
        $scope = ($response->toArray())['scope'];
        $refresh_token = ($response->toArray())['refresh_token'];

        dd($access_token, $expires_in, $token_type, $scope, $refresh_token);

        $token = $response;

        return $token;
    }
}