<?php

declare(strict_types=1);

namespace App;

use Exception;
use JetBrains\PhpStorm\ArrayShape;
use JsonSerializable;

class Mark implements JsonSerializable
{
    private string $jokeId;
    private string $authorId;
    private int $value;
    private int $timestamp;

    /**
     * @throws Exception
     */
    public function __construct(string $jokeId, string $authorId, int $value, int $timestamp)
    {
        if (empty($jokeId)) throw new Exception('Empty jokeId string.');
        $this->jokeId = $jokeId;

        if (empty($authorId)) throw new Exception('Empty authorId string.');
        $this->authorId = $authorId;

        if ($value < 1) throw new Exception('Mark cannot be negative.');
        $this->value = $value;

        if ($timestamp < 0) throw new Exception('Timestamp must be greater than zero.');
        $this->timestamp = $timestamp;
    }

    public function getJokeId(): string
    {
        return $this->jokeId;
    }

    public function getValue(): int
    {
        return $this->value;
    }

    #[ArrayShape([
        'jokeId' => 'string',
        'authorId' => 'string',
        'value' => 'string',
        'timestamp' => 'int',
    ])]
    public function jsonSerialize() : array
    {
        return [
            'jokeId' => $this->jokeId,
            'authorId' => $this->authorId,
            'value' => $this->value,
            'timestamp' => $this->timestamp,
        ];
    }
}
