<?php

declare(strict_types=1);

namespace App\File;

interface FileReaderInterface
{
    public function read(string $fileName): array;
}
