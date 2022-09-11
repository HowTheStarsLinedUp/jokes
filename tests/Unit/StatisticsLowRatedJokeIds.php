<?php

declare(strict_types=1);

namespace Unit;

use App\Statistics;
use PHPUnit\Framework\TestCase;

class StatisticsLowRatedJokeIds extends TestCase
{
    private array $expected = [
        '60dd358a37134ec38edeb820',
    ];
    private array $actual;
    private array $marks;
    private Statistics $stats;

    public function testGettingLowRatedJokeIds(): void
    {
        $this->givenStatistics();
        $this->whenGetLowRatedJokeIds();
        $this->thenCheckLowRatedJokeIds();
    }

    private function givenStatistics(): void
    {
        $this->stats = new Statistics();
        $this->marks = json_decode(file_get_contents('../marksExample.json'), true, flags: JSON_THROW_ON_ERROR);
    }

    private function whenGetLowRatedJokeIds(): void
    {
        $this->actual = $this->stats->getLowRatedJokeIds($this->marks);
    }

    private function thenCheckLowRatedJokeIds(): void
    {
        $this->assertEquals($this->expected, $this->actual);
    }
}
