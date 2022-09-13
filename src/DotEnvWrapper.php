<?php

declare(strict_types=1);

namespace App;

use Dotenv\Dotenv;

class DotEnvWrapper
{
    public string $projectDir;

    public function init()
    {
        $parts = explode(DIRECTORY_SEPARATOR, __DIR__);
        while (!empty($parts)) {
            if (array_pop($parts) == 'src') break;
        }
        $this->projectDir = implode(DIRECTORY_SEPARATOR, $parts);

        $dotenv = Dotenv::createImmutable($this->projectDir);
        $dotenv->load();
        $dotenv->required(['RAPIDAPI_KEY'])->notEmpty();
        $dotenv->required(['JOKES_FILE'])->notEmpty();
        $dotenv->required(['PERSONS_FILE'])->notEmpty();
        $dotenv->required(['MARKS_FILE'])->notEmpty();
    }
}
