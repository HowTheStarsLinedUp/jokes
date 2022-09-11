<?php

declare(strict_types=1);

namespace Unit;

use App\Statistics;
use PHPUnit\Framework\TestCase;

class StatisticsJokeIdsLowerThen extends TestCase
{
    private array $expected = ['60dd364d7251117d2e7e98b7', '60dd37bdff96470c011c87cf', '60dd358a37134ec38edeb820'];
    private array $actual;
    private int $limitMark = 4;
    private array $marks;
    private Statistics $stats;

    public function testGettingJokeIdsLowerThen(): void
    {
        $this->givenStatistics();
        $this->whenGetJokeIdsLowerThen();
        $this->thenCheckJokeIdsLowerThen();
    }

    private function givenStatistics(): void
    {
        $this->stats = new Statistics();
        $this->marks = json_decode(file_get_contents('../marksExample.json'), true, flags: JSON_THROW_ON_ERROR);
    }

    private function whenGetJokeIdsLowerThen(): void
    {
        $this->actual = $this->stats->getJokeIdsLowerThen($this->marks, $this->limitMark);
    }

    private function thenCheckJokeIdsLowerThen(): void
    {
        $this->assertEquals($this->expected, $this->actual);
    }
}
