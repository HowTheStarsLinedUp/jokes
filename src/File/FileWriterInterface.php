<?php

declare(strict_types=1);

namespace App\File;

interface FileWriterInterface
{
    public function write(array $data, string $fileName): void;
}
