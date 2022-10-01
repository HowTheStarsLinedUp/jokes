<?php

declare(strict_types=1);

namespace App;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use JsonException;

class ChuckApiClient implements JokeDownloaderInterface
{
    private const CHUCKNORRIS_SOURCE = 'chucknorris.io';
    private Client $client;
    private array $options;

    public function __construct(Client $client)
    {
        $this->client = $client;
        $this->options = [
            'headers' => [
                'Content-Type' => 'application/json'
            ]
        ];
    }

    /**
     * @return Joke[] Array of random jokes from random categories.
     * @throws GuzzleException
     * @throws JsonException
     * @throws Exception
     */
    public function downloadJokes(int $number): array
    {
        $jokes = [];
        $response = $this->client->request('GET', 'https://api.chucknorris.io/jokes/categories', $this->options);
        $categories = json_decode($response->getBody()->getContents(), true, flags: JSON_THROW_ON_ERROR);

        $catLen = count($categories);
        for ($i = 0; $i < $number; $i++) {
            $catNum = random_int(0, $catLen - 1);
            $url = 'https://api.chucknorris.io/jokes/random?category=' . $categories[$catNum];
            $response = $this->client->request('GET', $url, $this->options);
            $joke = json_decode($response->getBody()->getContents(), true, flags: JSON_THROW_ON_ERROR);
            $jokes[] = new Joke($joke['id'], $joke['value'], $categories[$catNum], ChuckApiClient::CHUCKNORRIS_SOURCE);
        }

        return $jokes;
    }
}
