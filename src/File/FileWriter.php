<?php

declare(strict_types=1);

namespace App\File;

use Exception;

class FileWriter
{
    public function write(array $data, string $fileName) : void
    {
        $ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        if ($ext != 'json' and $ext != 'csv') throw new Exception("Wrong file extension in: '$fileName'.");

        $writer =  'App\\File\\' . ucfirst($ext) . 'Writer';
        if (!class_exists($writer)) throw new Exception("'$writer' class not found.");

        (new $writer())->write($data, $fileName);
    }
}
