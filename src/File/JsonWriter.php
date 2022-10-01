<?php

declare(strict_types=1);

namespace App\File;

use Exception;
use JsonException;
use JsonSerializable;

class JsonWriter implements FileWriterInterface
{
    /**
     * @param JsonSerializable[] $data Array of json serializable objects
     * @throws Exception
     * @throws JsonException
     */
    public function write(array $data, string $fileName): void
    {
        $ext = pathinfo($fileName, PATHINFO_EXTENSION);
        if ($ext != 'json') throw new Exception("Error. Wrong file extension in: '$fileName'. Expected 'json'.");
        file_put_contents($fileName, json_encode($data, JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE), LOCK_EX);
    }
}
