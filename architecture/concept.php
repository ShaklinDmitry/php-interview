<?php

class Concept
{

    private $client;

    private $secretKeyService;

    public function __construct(SecretKeyServiceInterface $secretKeyService)
    {
        $this->client = new \GuzzleHttp\Client();
        $this->secretKeyService = $secretKeyService;
    }

    public function getUserData()
    {
        $params = [
          'auth' => ['user', 'pass'],
          'token' => $this->getSecretKey(),
        ];

        $request = new \Request('GET', 'https://api.method', $params);
        $promise = $this->client->sendAsync($request)->then(
          function ($response) {
              $result = $response->getBody();
          }
        );

        $promise->wait();
    }

    public function getSecretKey(): string
    {
        return $this->secretKeyService->getSecretKey();
    }

}

interface SecretKeyServiceInterface {}

class SecretKeyService implements SecretKeyServiceInterface
{

    public function getSecretKey()
    {
        switch (ENV::get('secretKeySource')) {
            case 'DB':
                return (new SecretKeyDB())->getKey();
            case 'File':
                return (new SecretKeyFile())->getKey();
            case 'InMemory':
                return (new SecretKeyInMemory())->getKey();
            case 'Cloud':
                return (new SecretKeyCloud())->getKey();
            default:
                throw new Exception(
                  'there is no such secret key interface ipmlementation'
                );
        }
    }

}


interface SecretKeyInterface{}

class SecretKeyDB implements SecretKeyInterface
{
}

class SecretKeyFile implements SecretKeyInterface
{
}

class SecretKeyInMemory implements SecretKeyInterface
{
}

class SecretKeyCloud implements SecretKeyInterface
{
}

