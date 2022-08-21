<?php

declare(strict_types=1);

namespace App;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use JsonException;

class DadJokesApiClient implements JokeProvider
{
    private const SOURCE = 'dad-jokes.p.rapidapi.com';
    private Client $client;
    private string $apiKey;

    public function __construct(Client $client, string $apiKey)
    {
        $this->client = $client;
        $this->apiKey = $apiKey;
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
                'X-RapidAPI-Key' => $this->apiKey,
                'X-RapidAPI-Host' => 'dad-jokes.p.rapidapi.com',
            ],
        ];

        $response = $this->client->request('GET', 'https://dad-jokes.p.rapidapi.com/random/joke', $options);
        $joke = json_decode($response->getBody()->getContents(), true, flags: JSON_THROW_ON_ERROR);
        $joke = $joke['body'][0];
        $text = 'Setup: ' . $joke['setup'] . ' Punchline: ' . $joke['punchline'];

        return new Joke($joke['_id'], $text, $joke['type'], DadJokesApiClient::SOURCE);
    }

    /**
     * @throws Exception|GuzzleException
     */
    public function getJokes(int $quantity) : array
    {
        if ($quantity > 250) {
            throw new Exception('Too many jokes. Max 250.');
        }

        // get jokes by count of $maxJokesByRequest and by $remainderRequestCount after;
        $jokes = [];
        $maxJokesByRequest = 5;
        $fullRequestCount = intdiv($quantity, $maxJokesByRequest);
        $remainderRequestCount = $quantity % $maxJokesByRequest;

        for ($i = 0; $i < $fullRequestCount; $i++) {
            array_push($jokes, ...$this->fetch($maxJokesByRequest));
        }
        array_push($jokes, ...$this->fetch($remainderRequestCount));

        return $jokes;
    }

    /**
     * @throws Exception|GuzzleException
     */
    private function fetch(int $jokesByRequest) : array
    {
        if ($jokesByRequest > 5) throw new Exception('Too many jokes. Max 5.');

        $jokes = [];
        $options = [
            'headers' => [
                'Content-Type' => 'application/json',
                'X-RapidAPI-Key' => $this->apiKey,
                'X-RapidAPI-Host' => 'dad-jokes.p.rapidapi.com',
            ],
        ];

        $url = 'https://dad-jokes.p.rapidapi.com/random/joke?count=' . $jokesByRequest;
        $response = $this->client->request('GET', $url, $options);
        $dadJokes = json_decode($response->getBody()->getContents(), true, flags: JSON_THROW_ON_ERROR);
        $dadJokes = $dadJokes['body'];

        $count = 0;
        foreach ($dadJokes as $dadJoke) {
            $text = 'Setup: ' . $dadJoke['setup'] . ' Punchline: ' . $dadJoke['punchline'];
            $jokes[] = new Joke($dadJoke['_id'], $text, $dadJoke['type'], DadJokesApiClient::SOURCE);
            // there is dad-jokes api bug, when you get more than requested.
            if (++$count > $jokesByRequest) break;
        }

        return $jokes;
    }
}
