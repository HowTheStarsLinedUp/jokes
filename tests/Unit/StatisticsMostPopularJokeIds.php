<?php

declare(strict_types=1);

namespace Unit;

use App\Statistics;
use PHPUnit\Framework\TestCase;

class StatisticsMostPopularJokeIds extends TestCase
{
    private array $expected = [
        'qqu1j77sqfkr-pekzhnk_q',
        '60dd364d7251117d2e7e98b7',
        '60dd38021dfc729d22050fe1',
        '60dd37b68edad440552c291e',
    ];
    private array $actual;
    private array $marks;
    private Statistics $stats;

    public function testGettingMostPopularJokeIds(): void
    {
        $this->givenStatistics();
        $this->whenGetMostPopularJokeIds();
        $this->thenCheckMostPopularJokeIds();
    }

    private function givenStatistics(): void
    {
        $this->stats = new Statistics();
        $this->marks = json_decode(file_get_contents('../marksExample.json'), true, flags: JSON_THROW_ON_ERROR);
    }

    private function whenGetMostPopularJokeIds(): void
    {
        $this->actual = $this->stats->getMostPopularJokeIds($this->marks);
    }

    private function thenCheckMostPopularJokeIds(): void
    {
        $this->assertEquals($this->expected, $this->actual);
    }
}
