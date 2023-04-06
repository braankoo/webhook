<?php

namespace BrankoDragovic\Webhook;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;

class HttpService
{
    private ClientInterface $client;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * @throws GuzzleException
     */
    public function sendRequest(
        string $url,
        string $method = 'GET',
        array $data = []
    ): string {
        $response = $this->client->request($method, $url, $data);

        return $response->getBody()->getContents();
    }
}
