<?php

declare(strict_types=1);

namespace App;

interface JokeDownloaderInterface
{
    public function downloadJokes(int $number) : array;
}
