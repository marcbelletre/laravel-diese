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
     *
     * @param  ?array  $data
     */
    private function makeRequest(string $url, ?array $data = []): mixed
    {
        $response = $this->client->request('POST', $url, [
            'headers' => $this->headers,
            'form_params' => $data,
        ]);

        return json_decode($response->getBody()->getContents())->message;
    }

    /**
     * Authenticate the client and set the token for next requests.
     */
    private function authenticate(): string
    {
        $token = $this->makeRequest('authentication');

        $this->headers['token'] = $token;

        return $token;
    }

    /**
     * Retrieve all productions.
     */
    public function getProductions(): array
    {
        $productions = $this->makeRequest('productions');

        return $productions;
    }
}
