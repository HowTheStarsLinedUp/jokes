<?php

declare(strict_types=1);

namespace App\File;

use Exception;

class CsvWriter implements FileWriterInterface
{
    /**
     * @throws Exception
     */
    public function write($data, $fileName): void
    {
        $ext = pathinfo($fileName, PATHINFO_EXTENSION);
        if ($ext != 'csv') throw new Exception("Wrong file extension in: '$fileName'. Expected 'csv'.");

        $fp = fopen($fileName, 'w');

        foreach ($data as $fields) {
            fputcsv($fp, $fields->jsonSerialize());
        }

        fclose($fp);
    }
}
