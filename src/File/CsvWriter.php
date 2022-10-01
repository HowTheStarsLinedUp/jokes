<?php

declare(strict_types=1);

namespace App\File;

use Exception;
use JsonSerializable;

class CsvWriter implements FileWriterInterface
{
    /**
     * @param JsonSerializable[] $data Array of json serializable objects
     * @throws Exception
     */
    public function write(array $data, string $fileName): void
    {
        $ext = pathinfo($fileName, PATHINFO_EXTENSION);
        if ($ext != 'csv') throw new Exception("Error. Wrong file extension in: '$fileName'. Expected 'csv'.");
        if (file_exists($fileName) && !is_writable($fileName)) throw new Exception("Error. File is not writable: '$fileName'.");

        $fp = fopen($fileName, 'w');
        if (!$fp) throw new Exception("Error. Can not open the file: '$fileName'.");

        // Writing column headers to first line of csv file.
        fputcsv($fp, array_keys($data[0]->jsonSerialize()));
        foreach ($data as $object) {
            fputcsv($fp, $object->jsonSerialize());
        }
        fclose($fp);
    }
}
