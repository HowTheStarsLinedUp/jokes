<?php

declare(strict_types=1);

namespace App\File;

use Exception;

class CsvReader
{
    public function read(string $fileName): string
    {
        if (pathinfo($fileName, PATHINFO_EXTENSION) != 'csv')
            throw new Exception("Wrong file extension in: '$fileName'. Expected 'csv'.");
        return 'some data';
    }
}
