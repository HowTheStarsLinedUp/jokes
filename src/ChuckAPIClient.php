<?php

declare(strict_types=1);

namespace App;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use JsonException;

class ChuckApiClient implements JokeProvider
{
    private const SOURCE = 'chucknorris.io';
    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @throws GuzzleException
     * @throws JsonException
     * @throws Exception
     */
    public function getJoke() : Joke
    {
        $options = [
            'headers' => [
                'Content-Type' => 'application/json',
            ],
        ];

        $response = $this->client->request('GET', 'https://api.chucknorris.io/jokes/categories', $options);
        $categories = json_decode($response->getBody()->getContents(), true, flags: JSON_THROW_ON_ERROR);
        $category = $categories[random_int(0, count($categories)-1)];
        $url = 'https://api.chucknorris.io/jokes/random?category=' . $category;
        $response = $this->client->request('GET', $url, $options);
        $joke = json_decode($response->getBody()->getContents(), true, flags: JSON_THROW_ON_ERROR);

        return new Joke($joke['id'], $joke['value'], $category, ChuckApiClient::SOURCE);
    }

    /**
     * @throws GuzzleException
     * @throws JsonException
     */
    public function getJokes(int $quantity) : array
    {
        $jokes = [];
        $options = [
            'headers' => [
                'Content-Type' => 'application/json',
            ],
        ];

        $response = $this->client->request('GET', 'https://api.chucknorris.io/jokes/categories', $options);
        $categories = json_decode($response->getBody()->getContents(), true, flags: JSON_THROW_ON_ERROR);

        $catNum = 0;
        $catLen = count($categories);
        for ($i = 0; $i < $quantity; $i++) {
            $url = 'https://api.chucknorris.io/jokes/random?category=' . $categories[$catNum];
            $response = $this->client->request('GET', $url, $options);
            $joke = json_decode($response->getBody()->getContents(), true, flags: JSON_THROW_ON_ERROR);
            $jokes[] = new Joke($joke['id'], $joke['value'], $categories[$catNum], ChuckApiClient::SOURCE);

            if (++$catNum == $catLen) {
                $catNum = 0;
            }
        }

        return $jokes;
    }
}
