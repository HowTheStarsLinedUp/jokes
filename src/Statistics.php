<?php

declare(strict_types=1);

namespace App;

use JetBrains\PhpStorm\ArrayShape;

class Statistics
{
    /**
     * @return array{jokeIds: string, mark: float} Average mark per joke
     */
    #[ArrayShape([
        'jokeId' => 'string',
        'value' => 'float',
    ])]
    public function getAvgMarkPerJoke(array $marks): array
    {
        $marksPerJoke = [];
        foreach ($marks as $mark) {
            $marksPerJoke[ $mark['jokeId'] ][] = $mark['value'];
        }
        foreach ($marksPerJoke as &$jokeMarks) {
            // make jokeMarks to be a joke average mark
            $jokeMarks = (float) bcdiv( (string)array_sum($jokeMarks), (string) count($jokeMarks), 3 );
        }

        return $marksPerJoke;
    }

    /**
     * Return joke IDs with average rating lower than $num.
     */
    #[ArrayShape([
        'jokeId' => 'string',
    ])]
    public function getJokeIdsLowerThen(array $marks, int $limitMark): array
    {
        return array_keys(array_filter($this->getAvgMarkPerJoke($marks), fn($markValue) => $markValue < $limitMark));
    }

    /**
     * Return the most low rated joke IDs with the lowest average rating.
     */
    #[ArrayShape([
        'jokeId' => 'string',
    ])]
    public function getLowRatedJokeIds(array $marks): array
    {
        $avgMarkPerJoke = $this->getAvgMarkPerJoke($marks);
        return array_keys($avgMarkPerJoke, min($avgMarkPerJoke));
    }

    /**
     * Return most popular joke IDs with the highest number of marks.
     */
    #[ArrayShape([
        'jokeId' => 'string',
    ])]
    public function getMostPopularJokeIds(array $marks): array
    {
        $markCounterPerJokeId = [];
        foreach ($marks as $mark) {
            $jokeId = $mark['jokeId'];
            if (!isset($markCounterPerJokeId[$jokeId])) $markCounterPerJokeId[$jokeId] = 0;
            $markCounterPerJokeId[$jokeId]++;
        }
        return array_keys($markCounterPerJokeId, max($markCounterPerJokeId));
    }

    /**
     * Return the most successful joke IDs with the highest average rating.
     */
    #[ArrayShape([
        'jokeId' => 'string',
    ])]
    public function getTopRatedJokeIds(array $marks): array
    {
        $avgMarkPerJoke = $this->getAvgMarkPerJoke($marks);
        return array_keys($avgMarkPerJoke, max($avgMarkPerJoke));
    }

    /**
     * @param array $marks
     *     $marks = [
     *          [
     *             'jokeId'    => (string)
     *             'authorId'  => (string)
     *             'value'     => (string)
     *             'timestamp' => (int)
     *         ]
     *         ...
     *     ]
     *
     * @return array{month: string, jokeIds: array} The most successful joke with the highest average rating per month.
     */
    #[ArrayShape([
        'month' => 'int',
        'jokeIds' => 'array',
        ])]
    public function getTopRatedJokeIdsPerMonth(array $marks): array
    {
        $marksByJokePerMonth = [];
        foreach ($marks as $mark) {
            // [months][jokeIDs][marks]
            $marksByJokePerMonth[ idate("m", $mark['timestamp']) ][] = $mark;
        }
        foreach ($marksByJokePerMonth as &$marksPerJoke) {
            $marksPerJoke = $this->getTopRatedJokeIds($marksPerJoke);
        }
        ksort($marksByJokePerMonth);

        // Now $marksByJokePerMonth is array of [month => topRatedJokeIds].
        return $marksByJokePerMonth;
    }
}
