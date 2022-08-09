<?php

declare(strict_types=1);

namespace App;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\{BadResponseException, RequestException, ConnectException, TransferException, GuzzleException};
use JsonException;

class ChuckAPIClient implements JokeProvider
{
    private Client $client;
    
    public function __construct($client)
    {
        $this->client = $client;
    }

    public function getJokes(int $number) : array
    {
        $jokes = [];
        $options = [
            'headers' => [
                'Content-Type' => 'application/json',
            ],
        ];

        try {
            $response = $this->client->request('GET', 'https://api.chucknorris.io/jokes/categories', $options);
            $categories = json_decode($response->getBody()->getContents(), true, flags: JSON_THROW_ON_ERROR);

            $cat = 0;
            $catLen = count($categories);
            for ($i = 0; $i < $number; $i++) {
                $url = 'https://api.chucknorris.io/jokes/random?category=' . $categories[$cat];
                $response = $this->client->request('GET', $url, $options);
                $joke = json_decode($response->getBody()->getContents(), true, flags: JSON_THROW_ON_ERROR);
                $myJoke = new Joke($joke['id'], $joke['value'], $categories[$cat], 'chucknorris.io');
                $jokes[] = $myJoke;

                if (++$cat == $catLen) {
                    $cat = 0;
                }
            }
        } catch (JsonException $e) {
            echo $e->getMessage();
        } catch (BadResponseException $e) {
            echo $e->getMessage();
        } catch (RequestException $e) {
            echo $e->getMessage();
        } catch (ConnectException $e) {
            echo $e->getMessage();
        } catch (TransferException $e) {
            echo $e->getMessage();
        } catch (GuzzleException $e) {
            echo $e->getMessage();
        }

        return $jokes;
    }
}
