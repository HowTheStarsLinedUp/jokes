<?php

declare(strict_types=1);

namespace App;

use GuzzleHttp\Client;
use JsonException;

class App
{
    public static array $cfg;

    public static function run() : void
    {
        $client = new Client(['timeout' => 2.0,]);
        
        $chuck = new ChuckAPIClient($client);
        $DadJokes = new DadJokesAPIClient($client, App::$cfg['APIKey']);
        $jokes = array_merge($chuck->getJokes(250), $DadJokes->getJokes(250));

        try {
            file_put_contents('data.json', json_encode($jokes, JSON_THROW_ON_ERROR), FILE_APPEND | LOCK_EX);
        } catch (JsonException $e) {
            echo 'JsonException' . PHP_EOL . $e->getMessage() . PHP_EOL;
        }
    }
}
