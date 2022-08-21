<?php

declare(strict_types=1);

namespace App;

use Exception;

class PersonsGenerator
{
    /**
     * @throws Exception
     */
    public static function generatePersons(int $count, string $personsDestFile) : void
    {
        $persons = [];

        for ($i = 0; $i < $count; $i++) {
            $persons[] = new Person(uniqid());
        }

        file_put_contents($personsDestFile, json_encode($persons, JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE), LOCK_EX);
    }
}
