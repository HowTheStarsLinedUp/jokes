<?php

declare(strict_types=1);

namespace App;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\{BadResponseException, RequestException, ConnectException, TransferException, GuzzleException};
use JsonException;
use Exception;

class DadJokesAPIClient implements JokeProvider
{
    private Client $client;
    private string $apiKey;

    public function __construct(Client $client, string $apiKey)
    {
        $this->client = $client;
        $this->apiKey = $apiKey;
    }

    /**
     * @throws Exception
     */
    private function getJokesBy5(int $number = 5) : array
    {
        if ($number > 5) throw new Exception('Too many jokes. Max 5.');
        if ($number > 5) {
            echo 'Too many jokes. Max 5.';
            die();
        };

        $jokes = [];
        $options = [
            'headers' => [
                'Content-Type' => 'application/json',
                'X-RapidAPI-Key' => $this->apiKey,
                'X-RapidAPI-Host' => 'dad-jokes.p.rapidapi.com',
            ],
        ];

        try {
            $url = 'https://dad-jokes.p.rapidapi.com/random/joke?count=' . $number;
            var_dump($url);
            $response = $this->client->request('GET', $url, $options);
            $joke = json_decode($response->getBody()->getContents(), true, flags: JSON_THROW_ON_ERROR);

            $dadJokes = $joke['body'];
            echo 'в $dadJokes: ' . strval(count($dadJokes)) . PHP_EOL;
            foreach ($dadJokes as $joke) {
                $text = 'Setup: ' . $joke['setup'] . ' Punchline: ' . $joke['punchline'];
                $myJoke = new Joke($joke['_id'], $text, $joke['type'], 'dad-jokes.p.rapidapi.com');
                $jokes[] = $myJoke;
            }
            echo 'кількість: ' . strval($number) . PHP_EOL;
            echo 'в масиві: ' . strval(count($jokes)) . PHP_EOL;
        } catch (JsonException $e) {
            echo 'JsonException' . PHP_EOL . $e->getMessage() . PHP_EOL;
        } catch (BadResponseException $e) {
            echo 'BadResponseException' . PHP_EOL . $e->getMessage() . PHP_EOL;
        } catch (RequestException $e) {
            echo 'RequestException' . PHP_EOL . $e->getMessage() . PHP_EOL;
        } catch (ConnectException $e) {
            echo 'ConnectException' . PHP_EOL . $e->getMessage() . PHP_EOL;
        } catch (TransferException $e) {
            echo 'TransferException' . PHP_EOL . $e->getMessage() . PHP_EOL;
        } catch (GuzzleException $e) {
            echo 'GuzzleException' . PHP_EOL . $e->getMessage() . PHP_EOL;
        }

        return $jokes;
    }

    /**
     * @throws Exception
     */
    public function getJokes(int $number) : array
    {
        if ($number > 250) {
            throw new Exception('Too many jokes. Max 250.');
        }

        $jokes = [];
        $by5 = intdiv($number, 5);
        $remainder = $number % 5;
        echo 'по 5: ' . strval($by5) . PHP_EOL;
        echo 'залишок: ' . strval($remainder) . PHP_EOL;

        for ($i = 0; $i < $by5; $i++) {
            $jokes = array_merge($jokes, $this->getJokesBy5());
        }
        if ($remainder != 0) {
            $jokes = array_merge($jokes, $this->getJokesBy5($remainder));
        }

        return $jokes;
    }
}

