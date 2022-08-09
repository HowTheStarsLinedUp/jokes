<?php

declare(strict_types=1);

namespace App;

interface JokeProvider
{
    public function getJokes(int $number) : array;
}
