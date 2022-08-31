<?php

declare(strict_types=1);

namespace App\File;

use Exception;
use JsonException;

class JsonWriter implements FileWriterInterface
{
    /**
     * @throws Exception
     * @throws JsonException
     */
    public function write(array $data, string $fileName) : void
    {
        $ext = pathinfo($fileName, PATHINFO_EXTENSION);
        if ($ext != 'json' and $ext != 'csv') throw new Exception("Wrong file extension in: '$fileName'.");

        file_put_contents($fileName, json_encode($data, JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE), LOCK_EX);
    }
}
