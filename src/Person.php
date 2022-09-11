<?php

declare(strict_types=1);

namespace App;

use Exception;
use JetBrains\PhpStorm\ArrayShape;
use JsonSerializable;

class Person implements JsonSerializable
{
    private string $id;

    public function __construct(string $id)
    {
        if (empty($id)) throw new Exception('Empty id string.');
        else $this->id = $id;
    }

    public function getId(): string
    {
        return $this->id;
    }

    #[ArrayShape([
        'id' => 'string',
    ])]
    public function jsonSerialize() : array
    {
        return [
            'id' => $this->id,
        ];
    }
}
