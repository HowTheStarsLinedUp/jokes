<?php

declare(strict_types=1);

namespace App;

use Exception;
use JsonMachine\Items;
use JsonMachine\JsonDecoder\ExtJsonDecoder;

class RatingMarksGenerator
{
    /**
     * @throws Exception
     */
    public static function generateRating(string $jokesSrcFile, string $personsSrcFile, string $marksDestFile) : void
    {
        $jokes = Items::fromFile($jokesSrcFile, ['decoder' => new ExtJsonDecoder(true)]);
        $persons = json_decode(file_get_contents($personsSrcFile), true, flags: JSON_THROW_ON_ERROR);
        $personsCount = count($persons);
        $marks = [];

        foreach ($jokes as $joke) {
            for ($i = 0; $i < random_int(0, 5); $i++) {
                $marks[] = new Mark(
                    $joke['sourceId'],
                    $persons[random_int(0, $personsCount-1)]['id'],
                    random_int(1, 10),
                    random_int(1640995200, 1672444800)
                );
            }
        }

        file_put_contents($marksDestFile, json_encode($marks, JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE), LOCK_EX);
    }
}
