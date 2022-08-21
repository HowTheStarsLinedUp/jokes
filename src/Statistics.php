<?php

declare(strict_types=1);

namespace App;

use JsonMachine\Exception\InvalidArgumentException;
use JsonMachine\Items;
use JsonMachine\JsonDecoder\ExtJsonDecoder;

class Statistics
{
//    перевірити при створенні джоука, чи не повторюється його айдішник


    /**
     * Return most popular joke with the highest number of marks.
     * If there is more than one most popular joke it gets the last one.
     * @throws InvalidArgumentException
     */
    public static function getMostPopularJokeId(string $marksFile) : string
    {
        // read one mark from file by iteration.
        $marks = Items::fromFile($marksFile, ['decoder' => new ExtJsonDecoder(true)]);
        $markCountersByJoke = [];
        foreach ($marks as $mark) {
            $jokeId = $mark['jokeId'];
            // creating a hash table of joke IDs => marks count.
            if (array_key_exists($jokeId, $markCountersByJoke)) {
                $markCountersByJoke[$jokeId] += 1;
            } else {
                $markCountersByJoke[$jokeId] = 1;
            }
        }

        $mostPopularJokeId = '';
        $maxCounter = 0;
        foreach ($markCountersByJoke as $id => $counter) {
            if ($counter > $maxCounter) {
                $maxCounter = $counter;
                $mostPopularJokeId = $id;
            }
        }

        return $mostPopularJokeId;
    }

    /**
     * Return average score per joke
     * @throws InvalidArgumentException
     */
    public static function getAvgMarkByJoke(string $marksFile) : array
    {
        // read one mark from file by iteration.
        $marks = Items::fromFile($marksFile, ['decoder' => new ExtJsonDecoder(true)]);
        $marksByJoke = [];
        foreach ($marks as $mark) {
            $marksByJoke[ $mark['jokeId'] ][] = $mark['value'];
        }

        foreach ($marksByJoke as &$jokeMarks) {
            $marksCount = count($jokeMarks);
            if($marksCount) {
                // make jokeMarks to be like jokeAverageMark
                $jokeMarks = round(array_sum($jokeMarks)/$marksCount, 3, PHP_ROUND_HALF_DOWN);
            }
        }

        return $marksByJoke;
    }

    /**
     * Return the most successful joke with the highest average rating.
     * @throws InvalidArgumentException
     */
    public static function getTopRatedJokeId(string $marksFile) : string
    {
        $avgMarkByJoke = Statistics::getAvgMarkByJoke($marksFile);

        $topRatedJokeId = '';
        $maxMark = 0;
        foreach ($avgMarkByJoke as $jokeId => $mark) {
            if ($mark > $maxMark) {
                $maxMark = $mark;
                $topRatedJokeId = $jokeId;
            }
        }

        return $topRatedJokeId;
    }

    /**
     * Return the most successful joke with the highest average rating per month.
     * @throws InvalidArgumentException
     */
    public static function getTopRatedJokeIdPerMonth(string $marksFile) : array
    {
        // read one mark from file by iteration.
        $marks = Items::fromFile($marksFile, ['decoder' => new ExtJsonDecoder(true)]);
        $marksByJokePerMonth = [];
        foreach ($marks as $mark) {
            $marksByJokePerMonth[ date("m", $mark['timestamp']) ][ $mark['jokeId'] ][] = $mark['value'];
        }

        foreach ($marksByJokePerMonth as &$marksByJoke) {
            // get average mark for every joke in month
            foreach ($marksByJoke as &$jokeMarks) {
                $marksCount = count($jokeMarks);
                if($marksCount) {
                    // make jokeMarks to be like jokeAverageMark
                    $jokeMarks = round(array_sum($jokeMarks)/$marksCount, 3, PHP_ROUND_HALF_DOWN);
                }
            }

            // get top-rated joke in month
            $topRatedJokeIdPerMonth = '';
            $maxMark = 0;
            foreach ($marksByJoke as $jokeId => $avgMark) {
                if ($avgMark > $maxMark) {
                    $maxMark = $avgMark;
                    $topRatedJokeIdPerMonth = $jokeId;
                }
            }

            $marksByJoke = $topRatedJokeIdPerMonth;
        }

        // Now $marksByJokePerMonth is array of (month => topRatedJokeId).
        return $marksByJokePerMonth;
    }
}
