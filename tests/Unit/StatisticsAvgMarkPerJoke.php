<?php

declare(strict_types=1);

namespace Unit;

use App\Statistics;
use PHPUnit\Framework\TestCase;

class StatisticsAvgMarkPerJoke extends TestCase
{
    private array $expected = [
        'cwguxfhptcuagndjdt1hya' => 7,
        'qqu1j77sqfkr-pekzhnk_q' => 6.25,
        'OSlTqFsNTPaYcnF5HRUKlw' => 5,
        '60dd35aba115ee7ff4c407dd' => 5.666,
        '60dd364d7251117d2e7e98b7' => 3.75,
        '60dd37bdff96470c011c87cf' => 3,
        '60dd38021dfc729d22050fe1' => 5.5,
        '60dd37b68edad440552c291e' => 5,
        '60dd358a37134ec38edeb820' => 2,
    ];
    private array $actual;
    private array $marks;
    private Statistics $stats;

//    private array $expectedDetails = [
//        'cwguxfhptcuagndjdt1hya' => [7],
//        'qqu1j77sqfkr-pekzhnk_q' => [3, 3, 9, 10],
//        'OSlTqFsNTPaYcnF5HRUKlw' => [5],
//        '60dd35aba115ee7ff4c407dd' => [6, 4, 7],
//        '60dd364d7251117d2e7e98b7' => [10, 2, 2, 1],
//        '60dd37bdff96470c011c87cf' => [3],
//        '60dd38021dfc729d22050fe1' => [4, 9, 7, 2],
//        '60dd37b68edad440552c291e' => [1, 7, 10, 2],
//        '60dd358a37134ec38edeb820' => [2, 2, 2],
//    ];

    public function testGettingAvgMarkPerJoke(): void
    {
        $this->givenStatistics();
        $this->whenGetAvgMarkPerJoke();
        $this->thenCheckAvgMarkPerJoke();
    }

    private function givenStatistics(): void
    {
        $this->stats = new Statistics();
        $this->marks = json_decode(file_get_contents('../marksExample.json'), true, flags: JSON_THROW_ON_ERROR);
    }

    private function whenGetAvgMarkPerJoke(): void
    {
        $this->actual = $this->stats->getAvgMarkPerJoke($this->marks);
    }

    private function thenCheckAvgMarkPerJoke(): void
    {
        $this->assertEquals($this->expected, $this->actual);
    }
}
