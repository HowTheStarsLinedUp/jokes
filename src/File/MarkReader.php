<?php

declare(strict_types=1);

namespace App\File;

use App\Mark;
use Exception;

class MarkReader
{
    public function read(string $fileName): array
    {
        $ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $reader = match ($ext) {
            'json' => new JsonReader(),
            'csv' => new CsvReader(),
            default => throw new Exception("Wrong file extension in: '$fileName'. Only json or csv are accepted.")
        };
        $marks = $reader->read($fileName);
        foreach ($marks as &$mark)
            $mark = new Mark(...$mark);

        return $marks;
    }
}
