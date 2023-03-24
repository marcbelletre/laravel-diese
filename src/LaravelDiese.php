<?php

namespace MarcBelletre\LaravelDiese;

use Exception;
use GuzzleHttp\Client;

class LaravelDiese
{
    protected Client $client;

    protected string $baseUri;

    protected array $headers;

    protected string $url;

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
    private function makeRequest(string $url, ?array $data = []): mixed
    {
        $response = $this->client->request('POST', $url, [
            'headers' => $this->headers,
            'body' => json_encode($data),
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
     * Retrieve a season by its ID.
     */
    public function getSeason(string|int $id, ?array $data = []): mixed
    {
        $seasons = $this->makeRequest("season/{$id}", $data);

        return $seasons[0] ?? null;
    }

    /**
     * Retrieve all seasons.
     */
    public function getSeasons(?array $data = []): array
    {
        return $this->makeRequest('seasons', $data);
    }

    /**
     * Retrieve all production types.
     */
    public function getProductionTypes(?array $data = []): array
    {
        return $this->makeRequest('productionTypes', $data);
    }

    /**
     * Retrieve a production type by its ID.
     */
    public function getProductionType(string|int $id, ?array $data = []): mixed
    {
        $productionTypes = $this->makeRequest("productionType/{$id}", $data);

        return $productionTypes[0] ?? null;
    }

    /**
     * Retrieve all productions.
     */
    public function getProductions(?array $data = []): array
    {
        return $this->makeRequest('productions', $data);
    }

    /**
     * Retrieve a production by its ID.
     */
    public function getProduction(string|int $id, ?array $data = []): mixed
    {
        $productions = $this->makeRequest("production/{$id}", $data);

        return $productions[0] ?? null;
    }

    /**
     * Retrieve all activity types.
     */
    public function getActivityTypes(?array $data = []): array
    {
        return $this->makeRequest('activityTypes', $data);
    }

    /**
     * Retrieve an activity type by its ID.
     */
    public function getActivityType(string|int $id, ?array $data = []): mixed
    {
        $activityTypes = $this->makeRequest("activityType/{$id}", $data);

        return $activityTypes[0] ?? null;
    }

    /**
     * Retrieve all activities.
     */
    public function getActivities(?array $data = []): array
    {
        return $this->makeRequest('activities', $data);
    }

    /**
     * Retrieve an activity by its ID.
     */
    public function getActivity(string|int $id, ?array $data = []): mixed
    {
        $activities = $this->makeRequest("activity/{$id}", $data);

        return $activities[0] ?? null;
    }
}
