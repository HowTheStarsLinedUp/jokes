<?php

declare(strict_types=1);

namespace App\File;

use Exception;

class CsvReader implements FileReaderInterface
{
    /**
     * @throws Exception
     * @return string[] Array of csv lines.
     */
    public function read(string $fileName): array
    {
        if (pathinfo($fileName, PATHINFO_EXTENSION) !== 'csv')
            throw new Exception("Error. Wrong file extension in: '$fileName'. Expected 'csv'.");

        $fp = fopen($fileName, 'r');
        if (!$fp) throw new Exception("Error. Can not open the file: '$fileName'.");

        $data = [];
        // Reading csv column headers.
        if (($line = fgetcsv($fp)) === false) throw new Exception("Error. Empty file: '$fileName'.");
        $headers = $line;
        while (($line = fgetcsv($fp)) !== false) {
            $data[] = array_combine($headers, $line);
        }

        fclose($fp);

        return $data;
    }
}
