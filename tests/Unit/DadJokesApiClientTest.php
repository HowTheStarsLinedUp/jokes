<?php

declare(strict_types=1);

namespace Unit;

use App\DadJokesApiClient;
use App\DotEnvWrapper;
use App\Joke;
use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;

class DadJokesApiClientTest extends TestCase
{
    public function testDownloadJokes()
    {
        (new DotEnvWrapper())->init();
        $options = [
            'headers' => [
                'Content-Type' => 'application/json',
                'X-RapidAPI-Key' => $_ENV['RAPIDAPI_KEY'],
                'X-RapidAPI-Host' => 'dad-jokes.p.rapidapi.com'
            ]
        ];
        $dadjokesClient = new DadJokesApiClient(new Client($options));

        $count = 1;
        $jokes = $dadjokesClient->downloadJokes($count);

        $this->assertContainsOnlyInstancesOf(Joke::class, $jokes);
        $this->assertCount(1, $jokes);

        $count = 6;
        $jokes = $dadjokesClient->downloadJokes($count);

        $this->assertContainsOnlyInstancesOf(Joke::class, $jokes);
        $this->assertCount(6, $jokes);
    }
}
