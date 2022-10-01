<?php

declare(strict_types=1);

namespace App\File;

use Exception;
use JsonException;
use JsonSerializable;

class FileWriter
{
    /**
     * @param JsonSerializable[] $data Array of json serializable objects
     * @throws JsonException
     * @throws Exception
     */
    public function write(array $data, string $fileName): void
    {
        $writer = match (strtolower(pathinfo($fileName, PATHINFO_EXTENSION))) {
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
