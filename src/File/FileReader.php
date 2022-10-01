<?php

declare(strict_types=1);

namespace App\File;

use Exception;
use JsonException;

class FileReader
{
    /**
     * @throws JsonException
     * @throws Exception
     */
    public function read(string $fileName): array
    {
        $reader = match (strtolower(pathinfo($fileName, PATHINFO_EXTENSION))) {
            'json' => new JsonReader(),
            'csv' => new CsvReader(),
            default => throw new Exception("Error. Wrong file extension in: '$fileName'.")
        };

        return $reader->read($fileName);
    }
}
