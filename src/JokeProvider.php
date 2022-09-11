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
    public function getJokes(int $number, ApiAlias $sourceAlias): array
    {
        $jokeDownloader = match ($sourceAlias->value) {
            $_ENV['CHUCKNORRIS_API_ALIAS'] => new ChuckApiClient($this->guzzleClient),
            $_ENV['DADJOKES_API_ALIAS'] => new DadJokesApiClient($this->guzzleClient),
            default => throw new Exception('Source is not valid.')
        };

        return $jokeDownloader->downloadJokes($number);
    }
}
