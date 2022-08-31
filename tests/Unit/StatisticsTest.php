<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Statistics;
use JsonMachine\Exception\InvalidArgumentException;
use JsonMachine\Items;
use JsonMachine\JsonDecoder\ExtJsonDecoder;
use PHPUnit\Framework\TestCase;

class StatisticsTest extends TestCase
{
    private static $exampleJson = '../marksExample.json';

    /**
     * @test
     * @throws InvalidArgumentException
     */
    public function getMostPopularJokeIdTest() : void
    {
        $expected = 'o-vfxwx6rgecuo_f5cecpq';
        $this->assertEquals($expected, Statistics::getMostPopularJokeId(self::$exampleJson));
    }

    /**
     * @test
     * @throws InvalidArgumentException
     */
    public function getAvgMarkByJokeTest() : void
    {
        $expected = [
            'o-vfxwx6rgecuo_f5cecpq' => 6.8,
            'cwguxfhptcuagndjdt1hya' => 7,
            'nbfmksvwq3stmubxphsfbw' => 4.667,
            '0gno3wclrfohs9a_mlx7rw' => 6.333,
            'JiqrAB-RRm-xYlPafESBVw' => 2,
            '0wdewlp2tz-mt_upesvrjw' => 6.5,
            'zk14uc6xr82d7ig9qhaymg' => 6,
            '4fmvnwfasrwmh58yjbuv1g' => 5,
        ];
//        print_r(self::getAllMarksByJokeHelper());
        $this->assertEquals($expected, Statistics::getAvgMarkPerJoke(self::$exampleJson));
    }

    /**
     * @test
     * @throws InvalidArgumentException
     */
    public function getTopRatedJokeIdTest() : void
    {
        $expected = 'cwguxfhptcuagndjdt1hya';
        $this->assertEquals($expected, Statistics::getTopRatedJokeId(self::$exampleJson));
    }

    /**
     * @test
     * @throws InvalidArgumentException
     */
    public function getTopRatedJokeIdPerMonthTest() : void
    {
        $expected = [
            '04' => 'o-vfxwx6rgecuo_f5cecpq',
            '03' => 'o-vfxwx6rgecuo_f5cecpq',
            '11' => '0gno3wclrfohs9a_mlx7rw',
            '06' => '0wdewlp2tz-mt_upesvrjw',
            '10' => 'nbfmksvwq3stmubxphsfbw',
            '02' => '0gno3wclrfohs9a_mlx7rw',
            '09' => 'JiqrAB-RRm-xYlPafESBVw',
            '12' => 'JiqrAB-RRm-xYlPafESBVw',
            '01' => 'o-vfxwx6rgecuo_f5cecpq',
            '07' => 'o-vfxwx6rgecuo_f5cecpq',
            '05' => 'o-vfxwx6rgecuo_f5cecpq',
            '08' => '4fmvnwfasrwmh58yjbuv1g',
        ];
//        print_r(self::getTopRatedJokeIdPerMonthHelper());
        $this->assertEquals($expected, Statistics::getTopRatedJokeIdPerMonth(self::$exampleJson));
    }

    /**
     * helper
     * @throws InvalidArgumentException
     */
    private function getAllMarksByJokeHelper() : array
    {
        // read one mark from file by iteration.
        $marks = Items::fromFile(self::$exampleJson, ['decoder' => new ExtJsonDecoder(true)]);
        $marksByJoke = [];
        foreach ($marks as $mark) {
            $marksByJoke[ $mark['jokeId'] ][] = $mark['value'];
        }

        return $marksByJoke;
    }

    /**
     * helper
     * @throws InvalidArgumentException
     */
    private function getTopRatedJokeIdPerMonthHelper() : array
    {
        // read one mark from file by iteration.
        $marks = Items::fromFile(self::$exampleJson, ['decoder' => new ExtJsonDecoder(true)]);
        $marksByJokePerMonth = [];
        foreach ($marks as $mark) {
            $marksByJokePerMonth[ date("m", $mark['timestamp']) ][ $mark['jokeId'] ][] = $mark['value'];
        }
        return $marksByJokePerMonth;
    }
}
