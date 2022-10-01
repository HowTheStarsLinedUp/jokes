<?php

declare(strict_types=1);

namespace Unit;

use App\ChuckApiClient;
use App\Joke;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Exception\TooManyRedirectsException;
use GuzzleHttp\Exception\TransferException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Exception;

class ChuckApiClientTest extends TestCase
{
    public function testDownloadJokes()
    {
        $options = [
            'headers' => [
                'Content-Type' => 'application/json'
            ]
        ];
        $chuckClient = new ChuckApiClient(new Client($options));

        $count = 1;
        $jokes = $chuckClient->downloadJokes($count);

        $this->assertContainsOnlyInstancesOf(Joke::class, $jokes);
        $this->assertCount($count, $jokes);

        $count = 6;
        $jokes = $chuckClient->downloadJokes($count);

        $this->assertContainsOnlyInstancesOf(Joke::class, $jokes);
        $this->assertCount($count, $jokes);
    }

    /**
     * @dataProvider guzzleClientExceptionDataProvider
     */
    public function testGuzzleClientExceptions(Exception $exception)
    {
        $mock = new MockHandler([$exception]);
        $handlerStack = HandlerStack::create($mock);
        $guzzleClient = new Client(['handler' => $handlerStack]);
        $chuckClient = new ChuckApiClient($guzzleClient);

        $this->expectException(get_class($exception));
        $this->expectExceptionMessage($exception->getMessage());
        $chuckClient->downloadJokes(1);
    }

    public function guzzleClientExceptionDataProvider(): array
    {
        return [
            'TransferException' => [new TransferException('TransferException test message.')],
            'ConnectException' => [new ConnectException('ConnectException test message.', new Request('GET', 'test'))],
            'RequestException' => [new RequestException('RequestException test message.', new Request('GET', 'test'))],
            'BadResponseException' => [new BadResponseException('BadResponseException test message.', new Request('GET', 'test'), new Response(500))],
            'ServerException' => [new ServerException('ServerException test message.', new Request('GET', 'test'), new Response(500))],
            'ClientException' => [new ClientException('ClientException test message.', new Request('GET', 'test'), new Response(404))],
            'TooManyRedirectsException' => [new TooManyRedirectsException('TooManyRedirectsException test message.', new Request('GET', 'test'), new Response(300))],
        ];
    }
}
