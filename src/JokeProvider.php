<?php

declare(strict_types=1);

namespace App;

interface JokeProvider
{
    public function getJoke() : Joke;
    public function getJokes(int $quantity) : array;
}
