<?php

declare(strict_types=1);

namespace App;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use JsonException;

class ChuckApiClient implements JokeDownloaderInterface
{
    public const CHUCKNORRIS_SOURCE = 'chucknorris.io';

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
     * Return array of random jokes from random categories.
     *
     * @throws Exception
     * @throws GuzzleException
     * @throws JsonException
     */
    public function downloadJokes(int $number) : array
    {
        $jokes = [];
        $response = $this->client->request('GET', 'https://api.chucknorris.io/jokes/categories', $this->options);
        $categories = json_decode($response->getBody()->getContents(), true, flags: JSON_THROW_ON_ERROR);

        $catNum = 0;
        $catLen = count($categories);
        for ($i = 0; $i < $number; $i++) {
            $url = 'https://api.chucknorris.io/jokes/random?category=' . $categories[$catNum];
            $response = $this->client->request('GET', $url, $this->options);
            $joke = json_decode($response->getBody()->getContents(), true, flags: JSON_THROW_ON_ERROR);
            $jokes[] = new Joke($joke['id'], $joke['value'], $categories[$catNum], ChuckApiClient::CHUCKNORRIS_SOURCE);

            if (++$catNum == $catLen) {
                $catNum = 0;
            }
        }

        return $jokes;
    }
}
