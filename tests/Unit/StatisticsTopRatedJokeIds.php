<?php

declare(strict_types=1);

namespace Unit;

use App\Statistics;
use PHPUnit\Framework\TestCase;

class StatisticsTopRatedJokeIds extends TestCase
{
    private array $expected = ['cwguxfhptcuagndjdt1hya'];
    private array $actual;
    private array $marks;
    private Statistics $stats;

    public function testGettingTopRatedJokeIds(): void
    {
        $this->givenStatistics();
        $this->whenGetTopRatedJokeIds();
        $this->thenCheckTopRatedJokeIds();
    }

    private function givenStatistics(): void
    {
        $this->stats = new Statistics();
        $this->marks = json_decode(file_get_contents('../marksExample.json'), true, flags: JSON_THROW_ON_ERROR);
    }

    private function whenGetTopRatedJokeIds(): void
    {
        $this->actual = $this->stats->getTopRatedJokeIds($this->marks);
    }

    private function thenCheckTopRatedJokeIds(): void
    {
        $this->assertEquals($this->expected, $this->actual);
    }
}
