<?php

declare(strict_types=1);

namespace App;

use JsonException;

class Statistics
{
    private array $marks;

    /**
     * @throws JsonException
     */
    public function __construct(string $marksFile)
    {
        $this->marks = json_decode(file_get_contents($marksFile), true, flags: JSON_THROW_ON_ERROR);
    }

    /**
     * Return most popular joke IDs with the highest number of marks.
     */
    public function getMostPopularJokeId() : array
    {
        $markCountersPerJokeId = [];
        foreach ($this->marks as $mark) {
            $jokeId = $mark['jokeId'];
            if (array_key_exists($jokeId, $markCountersPerJokeId)) {
                $markCountersPerJokeId[$jokeId] += 1;
            } else {
                $markCountersPerJokeId[$jokeId] = 1;
            }
        }

        return array_keys($markCountersPerJokeId, max($markCountersPerJokeId));
    }

    /**
     * Return average mark per joke
     */
    public function getAvgMarkPerJoke() : array
    {
        $marksPerJoke = [];
        foreach ($this->marks as $mark) {
            $marksPerJoke[ $mark['jokeId'] ][] = $mark['value'];
        }

        foreach ($marksPerJoke as &$jokeMarks) {
            $marksCount = count($jokeMarks);
            // make jokeMarks to be a joke average mark
            $jokeMarks = round(array_sum($jokeMarks)/$marksCount, 3, PHP_ROUND_HALF_DOWN);
        }

        return $marksPerJoke;
    }

    /**
     * Return the most successful joke IDs with the highest average rating.
     */
    public function getTopRatedJokeId() : array
    {
        $avgMarkPerJoke = $this->getAvgMarkPerJoke();
        return array_keys($avgMarkPerJoke, max($avgMarkPerJoke));
    }

    /**
     * Return the most low rated joke IDs with the lowest average rating.
     */
    public function getLowRatedJokeId() : array
    {
        $avgMarkPerJoke = $this->getAvgMarkPerJoke();
        return array_keys($avgMarkPerJoke, min($avgMarkPerJoke));
    }

    /**
     * Return joke IDs with average rating lower than $num.
     */
    public function getJokeIdsLowerThen(int $num) : array
    {
        $avgMarkPerJoke = $this->getAvgMarkPerJoke();
        return array_keys($avgMarkPerJoke, array_filter($avgMarkPerJoke, fn($value) => $value < $num));
    }

    /**
     * Return the most successful joke with the highest average rating per month.
     */
    public function getTopRatedJokeIdPerMonth() : array
    {
        $marksByJokePerMonth = [];
        foreach ($this->marks as $mark) {
            // [months][jokeIDs][marks]
            $marksByJokePerMonth[ date("m", $mark['timestamp']) ][ $mark['jokeId'] ][] = $mark['value'];
        }

        foreach ($marksByJokePerMonth as &$marksPerJoke) {
            // get average mark for every joke in month
            foreach ($marksPerJoke as &$jokeMarks) {
                $marksCount = count($jokeMarks);
                // make jokeMarks to be a joke average mark
                $jokeMarks = round(array_sum($jokeMarks)/$marksCount, 3, PHP_ROUND_HALF_DOWN);
            }

            // get top-rated joke in month
            // make $marksPerJoke to be an array of top rated joke IDs
            $marksPerJoke = array_keys($marksPerJoke, max($marksPerJoke));
        }

        // Now $marksByJokePerMonth is array of (month => topRatedJokeId).
        ksort($marksByJokePerMonth);
        return $marksByJokePerMonth;
    }
}
