<?php

declare(strict_types=1);

namespace App\File;

use Exception;

class JsonReader
{
    public function read(string $fileName): array
    {
        if (pathinfo($fileName, PATHINFO_EXTENSION) != 'json')
            throw new Exception("Wrong file extension in: '$fileName'. Expected 'json'.");
        return json_decode(file_get_contents($fileName), true, flags: JSON_THROW_ON_ERROR);
    }
}
