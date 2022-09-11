<?php

declare(strict_types=1);

namespace Unit;

use App\Statistics;
use PHPUnit\Framework\TestCase;

class StatisticsTopRatedJokeIdsPerMonth extends TestCase
{
    private array $expected = [
         1 => array ('cwguxfhptcuagndjdt1hya',),
         2 => array ('60dd35aba115ee7ff4c407dd',),
         3 => array ('60dd38021dfc729d22050fe1',),
         4 => array ('qqu1j77sqfkr-pekzhnk_q',),
         5 => array ('60dd37b68edad440552c291e',),
         6 => array ('60dd38021dfc729d22050fe1',),
         8 => array ('qqu1j77sqfkr-pekzhnk_q',),
        10 => array ('60dd364d7251117d2e7e98b7',),
        11 => array ('60dd37b68edad440552c291e', '60dd358a37134ec38edeb820',),
        12 => array ('qqu1j77sqfkr-pekzhnk_q',)
    ];
    private array $actual;
    private array $marks;
    private Statistics $stats;

//    private array $expectedDetails = array(
//        '01' => array(
//            array(
//                'jokeId' => 'cwguxfhptcuagndjdt1hya',
//                'authorId' => '631cab810e594',
//                'value' => 7,
//                'timestamp' => 1641765757,
//            ),
//            array(
//                'jokeId' => '60dd358a37134ec38edeb820',
//                'authorId' => '631cab810e59d',
//                'value' => 2,
//                'timestamp' => 1641008064,
//            ),
//        ),
//        '02' => array(
//            array(
//                'jokeId' => '60dd35aba115ee7ff4c407dd',
//                'authorId' => '631cab810e578',
//                'value' => 6,
//                'timestamp' => 1644582042,
//            ),
//        ),
//        '03' => array(
//            array(
//                'jokeId' => '60dd37bdff96470c011c87cf',
//                'authorId' => '631cab810e562',
//                'value' => 3,
//                'timestamp' => 1646545976,
//            ),
//            array(
//                'jokeId' => '60dd38021dfc729d22050fe1',
//                'authorId' => '631cab810e57f',
//                'value' => 9,
//                'timestamp' => 1647165668,
//            ),
//            array(
//                'jokeId' => '60dd37b68edad440552c291e',
//                'authorId' => '631cab810e58e',
//                'value' => 7,
//                'timestamp' => 1648663640,
//            ),
//        ),
//        '04' => array(
//            array(
//                'jokeId' => 'qqu1j77sqfkr-pekzhnk_q',
//                'authorId' => '631cab810e598',
//                'value' => 9,
//                'timestamp' => 1649170673,
//            ),
//            array(
//                'jokeId' => '60dd35aba115ee7ff4c407dd',
//                'authorId' => '631cab810e573',
//                'value' => 4,
//                'timestamp' => 1650525347,
//            ),
//        ),
//        '05' => array(
//            array(
//                'jokeId' => 'OSlTqFsNTPaYcnF5HRUKlw',
//                'authorId' => '631cab810e57f',
//                'value' => 5,
//                'timestamp' => 1652218553,
//            ),
//            array(
//                'jokeId' => '60dd38021dfc729d22050fe1',
//                'authorId' => '631cab810e58d',
//                'value' => 4,
//                'timestamp' => 1653336122,
//            ),
//            array(
//                'jokeId' => '60dd37b68edad440552c291e',
//                'authorId' => '631cab810e57f',
//                'value' => 10,
//                'timestamp' => 1651615144,
//            ),
//        ),
//        '06' => array(
//            array(
//                'jokeId' => '60dd38021dfc729d22050fe1',
//                'authorId' => '631cab810e566',
//                'value' => 7,
//                'timestamp' => 1656194721,
//            ),
//            array(
//                'jokeId' => '60dd37b68edad440552c291e',
//                'authorId' => '631cab810e562',
//                'value' => 1,
//                'timestamp' => 1655580418,
//            ),
//        ),
//        '08' => array(
//            array(
//                'jokeId' => 'qqu1j77sqfkr-pekzhnk_q',
//                'authorId' => '631cab810e57f',
//                'value' => 10,
//                'timestamp' => 1661365485,
//            ),
//            array(
//                'jokeId' => '60dd35aba115ee7ff4c407dd',
//                'authorId' => '631cab810e592',
//                'value' => 7,
//                'timestamp' => 1661716496,
//            ),
//        ),
//        10 => array(
//            array(
//                'jokeId' => 'qqu1j77sqfkr-pekzhnk_q',
//                'authorId' => '631cab810e599',
//                'value' => 3,
//                'timestamp' => 1665998195,
//            ),
//            array(
//                'jokeId' => '60dd364d7251117d2e7e98b7',
//                'authorId' => '631cab810e562',
//                'value' => 10,
//                'timestamp' => 1666418804,
//            ),
//            array(
//                'jokeId' => '60dd364d7251117d2e7e98b7',
//                'authorId' => '631cab810e576',
//                'value' => 2,
//                'timestamp' => 1665143813,
//            ),
//            array(
//                'jokeId' => '60dd38021dfc729d22050fe1',
//                'authorId' => '631cab810e590',
//                'value' => 2,
//                'timestamp' => 1666454341,
//            ),
//            array(
//                'jokeId' => '60dd358a37134ec38edeb820',
//                'authorId' => '631cab810e591',
//                'value' => 2,
//                'timestamp' => 1666581252,
//            ),
//        ),
//        11 => array(
//            array(
//                'jokeId' => '60dd364d7251117d2e7e98b7',
//                'authorId' => '631cab810e59e',
//                'value' => 1,
//                'timestamp' => 1668250960,
//            ),
//            array(
//                'jokeId' => '60dd37b68edad440552c291e',
//                'authorId' => '631cab810e568',
//                'value' => 2,
//                'timestamp' => 1668143968,
//            ),
//            array(
//                'jokeId' => '60dd358a37134ec38edeb820',
//                'authorId' => '631cab810e599',
//                'value' => 2,
//                'timestamp' => 1667298312,
//            ),
//        ),
//        12 => array(
//            array(
//                'jokeId' => 'qqu1j77sqfkr-pekzhnk_q',
//                'authorId' => '631cab810e59b',
//                'value' => 3,
//                'timestamp' => 1671261235,
//            ),
//            array(
//                'jokeId' => '60dd364d7251117d2e7e98b7',
//                'authorId' => '631cab810e575',
//                'value' => 2,
//                'timestamp' => 1670909682,
//            ),
//        )
//    );

    public function testGettingTopRatedJokeIdsPerMonth(): void
    {
        $this->givenStatistics();
        $this->whenGetTopRatedJokeIdsPerMonth();
        $this->thenCheckTopRatedJokeIdsPerMonth();
    }

    private function givenStatistics(): void
    {
        $this->stats = new Statistics();
        $this->marks = json_decode(file_get_contents('../marksExample.json'), true, flags: JSON_THROW_ON_ERROR);
    }

    private function whenGetTopRatedJokeIdsPerMonth(): void
    {
        $this->actual = $this->stats->getTopRatedJokeIdsPerMonth($this->marks);
    }

    private function thenCheckTopRatedJokeIdsPerMonth(): void
    {
        $this->assertEquals($this->expected, $this->actual);
    }
}
