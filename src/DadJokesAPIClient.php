<?php

declare(strict_types=1);

namespace App;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use JsonException;

class DadJokesApiClient implements JokeDownloaderInterface
{
    public const DADJOKES_SOURCE = 'dad-jokes.p.rapidapi.com';

    private string $baseUrl;
    private Client $client;
    private array $options;

    public function __construct(Client $client)
    {
        $this->baseUrl = 'https://dad-jokes.p.rapidapi.com/random/joke';
        $this->client = $client;
        $this->options = [
            'headers' => [
                'Content-Type' => 'application/json',
                'X-RapidAPI-Key' => $_ENV['RAPIDAPI_KEY'],
                'X-RapidAPI-Host' => 'dad-jokes.p.rapidapi.com'
            ]
        ];
    }

    /**
     * @return Joke[]
     * @throws GuzzleException
     * @throws JsonException
     *
     * @throws Exception
     */
    public function downloadJokes(int $number): array
    {
        if ($number > 250) {
            throw new Exception('Too many jokes. Max 250.');
        }

        // get jokes by count of $maxJokesByRequest and by $remainderRequestCount after;
        $jokes = [];
        $maxJokesByRequest = 5;
        $fullRequestCount = intdiv($number, $maxJokesByRequest);
        $remainderRequestCount = $number % $maxJokesByRequest;

        for ($i = 0; $i < $fullRequestCount; $i++) {
            array_push($jokes, ...$this->fetch($maxJokesByRequest));
        }
        array_push($jokes, ...$this->fetch($remainderRequestCount));

        return $jokes;
    }

    /**
     * @return Joke[]
     * @throws GuzzleException
     * @throws JsonException
     *
     * @throws Exception
     */
    private function fetch(int $jokesByRequest): array
    {
        if ($jokesByRequest > 5) throw new Exception('Too many jokes. Max 5.');

        $jokes = [];
        $url = $this->baseUrl . '?count=' . $jokesByRequest;
        $response = $this->client->request('GET', $url, $this->options);
        $dadJokes = json_decode($response->getBody()->getContents(), true, flags: JSON_THROW_ON_ERROR);
        $dadJokes = $dadJokes['body'];

        $count = 0;
        foreach ($dadJokes as $dadJoke) {
            $text = 'Setup: ' . $dadJoke['setup'] . ' Punchline: ' . $dadJoke['punchline'];
            $jokes[] = new Joke($dadJoke['_id'], $text, $dadJoke['type'], DadJokesApiClient::DADJOKES_SOURCE);
            // there is dad-jokes api bug, when you get more than requested.
            if (++$count > $jokesByRequest) break;
        }

        return $jokes;
    }
}
