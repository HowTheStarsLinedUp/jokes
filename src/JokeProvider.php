<?php

declare(strict_types=1);

namespace App;

use Exception;
use GuzzleHttp\Client;

class JokeProvider
{
    private Client $guzzleClient;

    public function __construct(Client $guzzleClient)
    {
        $this->guzzleClient = $guzzleClient;
    }

    public function getJokes(int $number, string $sourceAlias) : array
    {
        if ($sourceAlias == $_ENV['CHUCKNORRIS_API_ALIAS']) {
            $jokeDownloader = new ChuckApiClient($this->guzzleClient);
        } elseif ($sourceAlias == $_ENV['DADJOKES_API_ALIAS']) {
            $jokeDownloader = new DadJokesApiClient($this->guzzleClient);
        } else {
            if (empty($sourceAlias)) {
                throw new Exception('Empty source.');
            } else {
                throw new Exception('Source is not valid.');
            }
        }

        return $jokeDownloader->downloadJokes($number);
    }
}
