<?php

declare(strict_types=1);

namespace App\File;

use Exception;

class FileWriter
{
    public function write(array $data, string $fileName): void
    {
        $ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $writer = match ($ext) {
            'json' => new JsonWriter(),
            'csv' => new CsvWriter(),
            default => throw new Exception("Wrong file extension in: '$fileName'.")
        };
        $writer->write($data, $fileName);
    }
}
