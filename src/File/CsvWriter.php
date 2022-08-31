<?php

declare(strict_types=1);

namespace App\File;

use App\Joke;

class CsvWriter implements FileWriterInterface
{
    public function write($data, $fileName) : void
    {
        $fp = fopen($fileName, 'w');

        foreach ($data as $fields) {
            fputcsv($fp, $fields->jsonSerialize());
        }

        fclose($fp);
    }
}
