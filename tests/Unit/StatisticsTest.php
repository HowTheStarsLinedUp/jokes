<?php

declare(strict_types=1);

namespace Unit;

use App\Statistics;
use PHPUnit\Framework\TestCase;

class StatisticsTest extends TestCase
{
    private Statistics $stats;
    private $marks;

    protected function setUp(): void
    {
        $this->stats = new Statistics();
//        $this->marks = json_decode(file_get_contents('./tests/marksExample.json'), true, flags: JSON_THROW_ON_ERROR);
        $this->marks = $this->provideMarksData();
    }

    private function provideMarksData(): array
    {
        return [
            [
                "jokeId" => "cwguxfhptcuagndjdt1hya",
                "authorId" => "631cab810e594",
                "value" => 7,
                "timestamp" => 1641765757
            ],
            [
                "jokeId" => "qqu1j77sqfkr-pekzhnk_q",
                "authorId" => "631cab810e59b",
                "value" => 3,
                "timestamp" => 1671261235
            ],
            [
                "jokeId" => "qqu1j77sqfkr-pekzhnk_q",
                "authorId" => "631cab810e599",
                "value" => 3,
                "timestamp" => 1665998195
            ],
            [
                "jokeId" => "qqu1j77sqfkr-pekzhnk_q",
                "authorId" => "631cab810e598",
                "value" => 9,
                "timestamp" => 1649170673
            ],
            [
                "jokeId" => "qqu1j77sqfkr-pekzhnk_q",
                "authorId" => "631cab810e57f",
                "value" => 10,
                "timestamp" => 1661365485
            ],
            [
                "jokeId" => "OSlTqFsNTPaYcnF5HRUKlw",
                "authorId" => "631cab810e57f",
                "value" => 5,
                "timestamp" => 1652218553
            ],
            [
                "jokeId" => "60dd35aba115ee7ff4c407dd",
                "authorId" => "631cab810e578",
                "value" => 6,
                "timestamp" => 1644582042
            ],
            [
                "jokeId" => "60dd35aba115ee7ff4c407dd",
                "authorId" => "631cab810e573",
                "value" => 4,
                "timestamp" => 1650525347
            ],
            [
                "jokeId" => "60dd35aba115ee7ff4c407dd",
                "authorId" => "631cab810e592",
                "value" => 7,
                "timestamp" => 1661716496
            ],
            [
                "jokeId" => "60dd364d7251117d2e7e98b7",
                "authorId" => "631cab810e562",
                "value" => 10,
                "timestamp" => 1666418804
            ],
            [
                "jokeId" => "60dd364d7251117d2e7e98b7",
                "authorId" => "631cab810e575",
                "value" => 2,
                "timestamp" => 1670909682
            ],
            [
                "jokeId" => "60dd364d7251117d2e7e98b7",
                "authorId" => "631cab810e576",
                "value" => 2,
                "timestamp" => 1665143813
            ],
            [
                "jokeId" => "60dd364d7251117d2e7e98b7",
                "authorId" => "631cab810e59e",
                "value" => 1,
                "timestamp" => 1668250960
            ],
            [
                "jokeId" => "60dd37bdff96470c011c87cf",
                "authorId" => "631cab810e562",
                "value" => 3,
                "timestamp" => 1646545976
            ],
            [
                "jokeId" => "60dd38021dfc729d22050fe1",
                "authorId" => "631cab810e58d",
                "value" => 4,
                "timestamp" => 1653336122
            ],
            [
                "jokeId" => "60dd38021dfc729d22050fe1",
                "authorId" => "631cab810e57f",
                "value" => 9,
                "timestamp" => 1647165668
            ],
            [
                "jokeId" => "60dd38021dfc729d22050fe1",
                "authorId" => "631cab810e566",
                "value" => 7,
                "timestamp" => 1656194721
            ],
            [
                "jokeId" => "60dd38021dfc729d22050fe1",
                "authorId" => "631cab810e590",
                "value" => 2,
                "timestamp" => 1666454341
            ],
            [
                "jokeId" => "60dd37b68edad440552c291e",
                "authorId" => "631cab810e562",
                "value" => 1,
                "timestamp" => 1655580418
            ],
            [
                "jokeId" => "60dd37b68edad440552c291e",
                "authorId" => "631cab810e58e",
                "value" => 7,
                "timestamp" => 1648663640
            ],
            [
                "jokeId" => "60dd37b68edad440552c291e",
                "authorId" => "631cab810e57f",
                "value" => 10,
                "timestamp" => 1651615144
            ],
            [
                "jokeId" => "60dd37b68edad440552c291e",
                "authorId" => "631cab810e568",
                "value" => 2,
                "timestamp" => 1668143968
            ],
            [
                "jokeId" => "60dd358a37134ec38edeb820",
                "authorId" => "631cab810e599",
                "value" => 2,
                "timestamp" => 1667298312
            ],
            [
                "jokeId" => "60dd358a37134ec38edeb820",
                "authorId" => "631cab810e591",
                "value" => 2,
                "timestamp" => 1666581252
            ],
            [
                "jokeId" => "60dd358a37134ec38edeb820",
                "authorId" => "631cab810e59d",
                "value" => 2,
                "timestamp" => 1641008064
            ]
        ];
    }

    public function testAvgMarkPerJoke(): void
    {
        $expected = [
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

//        $allMarksPerJokeComment = [
//            'cwguxfhptcuagndjdt1hya' => [7],
//            'qqu1j77sqfkr-pekzhnk_q' => [3, 3, 9, 10],
//            'OSlTqFsNTPaYcnF5HRUKlw' => [5],
//            '60dd35aba115ee7ff4c407dd' => [6, 4, 7],
//            '60dd364d7251117d2e7e98b7' => [10, 2, 2, 1],
//            '60dd37bdff96470c011c87cf' => [3],
//            '60dd38021dfc729d22050fe1' => [4, 9, 7, 2],
//            '60dd37b68edad440552c291e' => [1, 7, 10, 2],
//            '60dd358a37134ec38edeb820' => [2, 2, 2],
//       ];

        $actual = $this->stats->getAvgMarkPerJoke($this->marks);
        $this->assertEquals($expected, $actual);
    }

    public function testJokeIdsLowerThen()
    {
        $expected = ['60dd364d7251117d2e7e98b7', '60dd37bdff96470c011c87cf', '60dd358a37134ec38edeb820'];
        $limitMark = 4;
        $actual = $this->stats->getJokeIdsLowerThen($this->marks, $limitMark);
        $this->assertEquals($expected, $actual);
    }

    public function testLowRatedJokeIds(): void
    {
        $expected = ['60dd358a37134ec38edeb820'];
        $actual = $this->stats->getLowRatedJokeIds($this->marks);
        $this->assertEquals($expected, $actual);
    }

    public function testMostPopularJokeIds(): void
    {
        $expected = [
            'qqu1j77sqfkr-pekzhnk_q',
            '60dd364d7251117d2e7e98b7',
            '60dd38021dfc729d22050fe1',
            '60dd37b68edad440552c291e',
        ];
        $actual = $this->stats->getMostPopularJokeIds($this->marks);
        $this->assertEquals($expected, $actual);
    }

    public function testTopRatedJokeIdsPerMonth(): void
    {
        $expected = [
            1 => array('cwguxfhptcuagndjdt1hya',),
            2 => array('60dd35aba115ee7ff4c407dd',),
            3 => array('60dd38021dfc729d22050fe1',),
            4 => array('qqu1j77sqfkr-pekzhnk_q',),
            5 => array('60dd37b68edad440552c291e',),
            6 => array('60dd38021dfc729d22050fe1',),
            8 => array('qqu1j77sqfkr-pekzhnk_q',),
            10 => array('60dd364d7251117d2e7e98b7',),
            11 => array('60dd37b68edad440552c291e', '60dd358a37134ec38edeb820',),
            12 => array('qqu1j77sqfkr-pekzhnk_q',)
        ];

//        $jokesPerMonthComment = array(
//            '01' => array(
//                array(
//                    'jokeId' => 'cwguxfhptcuagndjdt1hya',
//                    'authorId' => '631cab810e594',
//                    'value' => 7,
//                    'timestamp' => 1641765757,
//                ),
//                array(
//                    'jokeId' => '60dd358a37134ec38edeb820',
//                    'authorId' => '631cab810e59d',
//                    'value' => 2,
//                    'timestamp' => 1641008064,
//                ),
//            ),
//            '02' => array(
//                array(
//                    'jokeId' => '60dd35aba115ee7ff4c407dd',
//                    'authorId' => '631cab810e578',
//                    'value' => 6,
//                    'timestamp' => 1644582042,
//                ),
//            ),
//            '03' => array(
//                array(
//                    'jokeId' => '60dd37bdff96470c011c87cf',
//                    'authorId' => '631cab810e562',
//                    'value' => 3,
//                    'timestamp' => 1646545976,
//                ),
//                array(
//                    'jokeId' => '60dd38021dfc729d22050fe1',
//                    'authorId' => '631cab810e57f',
//                    'value' => 9,
//                    'timestamp' => 1647165668,
//                ),
//                array(
//                    'jokeId' => '60dd37b68edad440552c291e',
//                    'authorId' => '631cab810e58e',
//                    'value' => 7,
//                    'timestamp' => 1648663640,
//                ),
//            ),
//            '04' => array(
//                array(
//                    'jokeId' => 'qqu1j77sqfkr-pekzhnk_q',
//                    'authorId' => '631cab810e598',
//                    'value' => 9,
//                    'timestamp' => 1649170673,
//                ),
//                array(
//                    'jokeId' => '60dd35aba115ee7ff4c407dd',
//                    'authorId' => '631cab810e573',
//                    'value' => 4,
//                    'timestamp' => 1650525347,
//                ),
//            ),
//            '05' => array(
//                array(
//                    'jokeId' => 'OSlTqFsNTPaYcnF5HRUKlw',
//                    'authorId' => '631cab810e57f',
//                    'value' => 5,
//                    'timestamp' => 1652218553,
//                ),
//                array(
//                    'jokeId' => '60dd38021dfc729d22050fe1',
//                    'authorId' => '631cab810e58d',
//                    'value' => 4,
//                    'timestamp' => 1653336122,
//                ),
//                array(
//                    'jokeId' => '60dd37b68edad440552c291e',
//                    'authorId' => '631cab810e57f',
//                    'value' => 10,
//                    'timestamp' => 1651615144,
//                ),
//            ),
//            '06' => array(
//                array(
//                    'jokeId' => '60dd38021dfc729d22050fe1',
//                    'authorId' => '631cab810e566',
//                    'value' => 7,
//                    'timestamp' => 1656194721,
//                ),
//                array(
//                    'jokeId' => '60dd37b68edad440552c291e',
//                    'authorId' => '631cab810e562',
//                    'value' => 1,
//                    'timestamp' => 1655580418,
//                ),
//            ),
//            '08' => array(
//                array(
//                    'jokeId' => 'qqu1j77sqfkr-pekzhnk_q',
//                    'authorId' => '631cab810e57f',
//                    'value' => 10,
//                    'timestamp' => 1661365485,
//                ),
//                array(
//                    'jokeId' => '60dd35aba115ee7ff4c407dd',
//                    'authorId' => '631cab810e592',
//                    'value' => 7,
//                    'timestamp' => 1661716496,
//                ),
//            ),
//            10 => array(
//                array(
//                    'jokeId' => 'qqu1j77sqfkr-pekzhnk_q',
//                    'authorId' => '631cab810e599',
//                    'value' => 3,
//                    'timestamp' => 1665998195,
//                ),
//                array(
//                    'jokeId' => '60dd364d7251117d2e7e98b7',
//                    'authorId' => '631cab810e562',
//                    'value' => 10,
//                    'timestamp' => 1666418804,
//                ),
//                array(
//                    'jokeId' => '60dd364d7251117d2e7e98b7',
//                    'authorId' => '631cab810e576',
//                    'value' => 2,
//                    'timestamp' => 1665143813,
//                ),
//                array(
//                    'jokeId' => '60dd38021dfc729d22050fe1',
//                    'authorId' => '631cab810e590',
//                    'value' => 2,
//                    'timestamp' => 1666454341,
//                ),
//                array(
//                    'jokeId' => '60dd358a37134ec38edeb820',
//                    'authorId' => '631cab810e591',
//                    'value' => 2,
//                    'timestamp' => 1666581252,
//                ),
//            ),
//            11 => array(
//                array(
//                    'jokeId' => '60dd364d7251117d2e7e98b7',
//                    'authorId' => '631cab810e59e',
//                    'value' => 1,
//                    'timestamp' => 1668250960,
//                ),
//                array(
//                    'jokeId' => '60dd37b68edad440552c291e',
//                    'authorId' => '631cab810e568',
//                    'value' => 2,
//                    'timestamp' => 1668143968,
//                ),
//                array(
//                    'jokeId' => '60dd358a37134ec38edeb820',
//                    'authorId' => '631cab810e599',
//                    'value' => 2,
//                    'timestamp' => 1667298312,
//                ),
//            ),
//            12 => array(
//                array(
//                    'jokeId' => 'qqu1j77sqfkr-pekzhnk_q',
//                    'authorId' => '631cab810e59b',
//                    'value' => 3,
//                    'timestamp' => 1671261235,
//                ),
//                array(
//                    'jokeId' => '60dd364d7251117d2e7e98b7',
//                    'authorId' => '631cab810e575',
//                    'value' => 2,
//                    'timestamp' => 1670909682,
//                ),
//            )
//        );

        $actual = $this->stats->getTopRatedJokeIdsPerMonth($this->marks);
        $this->assertEquals($expected, $actual);
    }

    public function testTopRatedJokeIds(): void
    {
        $expected = ['cwguxfhptcuagndjdt1hya'];
        $actual = $this->stats->getTopRatedJokeIds($this->marks);
        $this->assertEquals($expected, $actual);
    }
}
