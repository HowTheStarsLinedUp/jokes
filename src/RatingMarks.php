<?php

declare(strict_types=1);

namespace App;

use JsonException;

class RatingMarks
{
    public static function generateRating() : void
    {
        $marks = [];
        try {
            $jokes = json_decode(file_get_contents('../data.json'), true, flags: JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            echo 'JsonException' . PHP_EOL . $e->getMessage() . PHP_EOL;
        }

        foreach ($jokes as $joke) {
            $marks[] = ['jokeID' => $joke['id'], 'uuid' => uniqid(), 'mark' => random_int(1,10)];
        }

        try {
            file_put_contents('../marks.json', json_encode($marks, JSON_THROW_ON_ERROR), LOCK_EX);
        } catch (JsonException $e) {
            echo 'JsonException' . PHP_EOL . $e->getMessage() . PHP_EOL;
        }
    }
}

RatingMarks::generateRating();
