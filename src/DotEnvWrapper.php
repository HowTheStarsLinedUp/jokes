<?php

declare(strict_types=1);

namespace App;

use Dotenv\Dotenv;

class DotEnvWrapper
{
    public string $projectDir;

    public function init(): void
    {
        $parts = explode(DIRECTORY_SEPARATOR, __DIR__);
        while (!empty($parts)) {
            if (array_pop($parts) == 'src') break;
        }
        $this->projectDir = implode(DIRECTORY_SEPARATOR, $parts);

        $dotenv = Dotenv::createImmutable($this->projectDir);
        $dotenv->load();
        $dotenv->required([
            'RAPIDAPI_KEY',
            'CHUCKNORRIS_API_ALIAS',
            'DADJOKES_API_ALIAS',
            'GUZZLE_CLIENT_TIMEOUT',
            'JOKES_FILE',
            'PERSONS_FILE',
            'MARKS_FILE',
        ])->notEmpty();
    }
}
