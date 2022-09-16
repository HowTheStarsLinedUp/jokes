<?php

declare(strict_types=1);

namespace App\File;

use Exception;
use JsonException;

class FileWriter
{
    /**
     * @throws JsonException
     * @throws Exception
     */
    public function write(array $data, string $fileName): void
    {
        $ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $writer = match ($ext) {
            'json' => new JsonWriter(),
            'csv' => new CsvWriter(),
            default => throw new Exception("Error. Wrong file extension in: '$fileName'.")
        };

        $folders = explode('/', $fileName);
        array_pop($folders);

        $path = '';
        foreach ($folders as $folder) {
            if ($folder == '.') {
                $path .= $folder;
                continue;
            }
            $path .= "/$folder";
            if (!is_dir($path)) mkdir($path);
        }

        $writer->write($data, $fileName);
    }
}
