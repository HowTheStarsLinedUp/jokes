<?php

declare(strict_types=1);

namespace App;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use JsonException;

class App
{
    /**
     * @throws JsonException
     * @throws GuzzleException
     */
    public static function run(string $jokesFile, string $personsFile, string $marksFile) : void
    {
        $jokes = [];
        if (file_exists($jokesFile)) {
            $jokes = json_decode(file_get_contents($jokesFile), true, flags: JSON_THROW_ON_ERROR);
        }

        $client = new Client(['timeout' => 2.0,]);
        $chuck = new ChuckApiClient($client);
        $dadJokes = new DadJokesApiClient($client, $_ENV['apiKey']);

        var_dump(count($jokes));
        array_push($jokes, ...$chuck->getJokes(6));
        var_dump(count($jokes));
        array_push($jokes, ...$dadJokes->getJokes(6));
        var_dump(count($jokes));
        $jokes[] = $chuck->getJoke();
        var_dump(count($jokes));
        $jokes[] = $dadJokes->getJoke();
        var_dump(count($jokes));

        file_put_contents($jokesFile, json_encode($jokes, JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE), LOCK_EX);

        if (!file_exists($personsFile)) PersonsGenerator::generatePersons(50, $personsFile);

        RatingMarksGenerator::generateRating($jokesFile, $personsFile, $marksFile);

        var_dump(Statistics::getMostPopularJokeId($marksFile));
        var_dump(Statistics::getTopRatedJokeId($marksFile));
        var_dump(Statistics::getAvgMarkByJoke($marksFile));
        var_dump(Statistics::getTopRatedJokeIdPerMonth($marksFile));
    }
}
