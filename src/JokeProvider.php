<?php

declare(strict_types=1);

namespace App;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use JsonException;

class JokeProvider
{
    private Client $guzzleClient;

    public function __construct(Client $guzzleClient)
    {
        $this->guzzleClient = $guzzleClient;
    }

    /**
     * @return Joke[]
     * @throws GuzzleException
     * @throws JsonException
     *
     * @throws Exception
     */
    public function getJokes(int $number, string $sourceAlias, array $cfg): array
    {
        $jokeApiClient = match ($sourceAlias) {
            $cfg['CHUCKNORRIS_API_ALIAS'] => new ChuckApiClient($this->guzzleClient),
            $cfg['DADJOKES_API_ALIAS'] => new DadJokesApiClient($this->guzzleClient)
        };

        return $jokeApiClient->downloadJokes($number);
    }
}
