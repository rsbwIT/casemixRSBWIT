<?php

namespace App\Services\RsbwFktl;
use Dotenv\Dotenv;
use GuzzleHttp\Client;

class SetupRSBW
{
    protected $url;
    protected $username;
    protected $password;
    public function __construct()
    {
        $dotenv = Dotenv::createUnsafeImmutable(getcwd());
		$dotenv->safeLoad();

        $this->url = getenv('MJKN_RS');
        $this->username = getenv('X_USERNAME');
        $this->password = getenv('X_PASSWORD');
    }

    public function getUrl() {
        return $this->url;
    }
    public function getUsername() {
        return $this->username;
    }
    public function getPassword() {
        return $this->password;
    }

    public function getToken()
    {
        $client = new Client();
        try {
            $response = $client->request('GET', $this->getUrl().'/auth', [
                'headers' => [
                    'x-username' => $this->getUsername(),
                    'x-password' => $this->getPassword()
                ],
            ]);
            $data = json_decode($response->getBody()->getContents());
            return $data->response->token;
        } catch (\Throwable $th) {
            return ['response'];
        }
    }

    private function createHeaders()
    {
        return [
            'x-token' => $this->getToken(),
            'x-username' => $this->getUsername(),
            'Content-Type' => 'application/json'
        ];
    }

    // 1 POST REQUESET
    public function postRequest($data, $endpoin) {
        try {
            $client = new Client();
            $headers = $this->createHeaders();
            $response = $client->request('POST', $this->getUrl().$endpoin , [
                'headers' => $headers,
                'json' => $data,
            ]);
            $responseData = json_decode($response->getBody()->getContents());
            return $responseData;
        } catch (\Exception $e) {
            return [];
        }
    }
}
