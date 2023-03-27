<?php

namespace MarcBelletre\LaravelDiese;

use Exception;
use GuzzleHttp\Client;

class LaravelDiese
{
    protected Client $client;

    protected string $baseUri;

    protected array $headers;

    /**
     * Create a new Client instance.
     */
    public function __construct()
    {
        $this->setup();
    }

    /**
     * Configure the API client.
     */
    private function setup(): void
    {
        $clientId = config('diese.client_id');
        $subClientId = config('diese.sub_client_id') ?: $clientId;
        $apiKey = config('diese.api_key');

        if (! ($clientId && $apiKey)) {
            throw new Exception('Credentials not found. Please set Client ID and API Key.');
        }

        $this->baseUri = "https://{$clientId}.diesesoftware.com/_app/{$subClientId}/api/";
        $this->headers = [
            'Authorization' => $apiKey,
            'Idclient' => $subClientId,
        ];

        $this->client = new Client([
            'base_uri' => $this->baseUri,
        ]);

        $this->authenticate();
    }

    /**
     * Perform a POST request.
     */
    private function makeRequest(string $url, array $data, bool $first = false): mixed
    {
        $response = $this->client->request('POST', $url, [
            'headers' => $this->headers,
            'body' => json_encode($data),
        ]);

        $json = json_decode($response->getBody()->getContents());

        if ($json->error) {
            throw new Exception($json->message);
        }

        if ($first) {
            return $json->message[0] ?? null;
        }

        return $json->message;
    }

    /**
     * Authenticate the client and set the token for next requests.
     */
    private function authenticate(): string
    {
        $token = $this->makeRequest('authentication', []);

        $this->headers['token'] = $token;

        return $token;
    }

    /**
     * Get multiple records.
     */
    public function get(string $url, ?array $data = []): array
    {
        return $this->makeRequest($url, $data);
    }

    /**
     * Get one record by its ID.
     */
    public function find(string $url, mixed $id, ?array $data = []): mixed
    {
        return $this->makeRequest("{$url}/{$id}", $data, true);
    }
}
