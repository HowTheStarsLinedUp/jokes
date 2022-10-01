<?php

declare(strict_types=1);

namespace App\File;

use Exception;
use JsonException;

class JsonReader
{
    /**
     * @throws JsonException
     * @throws Exception
     */
    public function read(string $fileName): array
    {
        if (pathinfo($fileName, PATHINFO_EXTENSION) != 'json')
            throw new Exception("Error. Wrong file extension in: '$fileName'. Expected 'json'.");
        return json_decode(file_get_contents($fileName), true, flags: JSON_THROW_ON_ERROR);
    }
}
