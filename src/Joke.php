<?php

declare(strict_types=1);

namespace App;

use Exception;
use JetBrains\PhpStorm\ArrayShape;
use JsonSerializable;

class Joke implements JsonSerializable
{
    private string $sourceId;
    private string $text;
    private ?string $category;
    private string $source;

    /**
     * @throws Exception
     */
    public function __construct(string $sourceId, string $text, ?string $category, string $source)
    {
        if (empty($sourceId)) throw new Exception('Empty id string.');
        $this->sourceId = $sourceId;

        if (empty($text)) throw new Exception('Empty text string.');
        $this->text = $text;

        $this->category = $category;

        if (empty($source)) throw new Exception('Empty source string.');
        $this->source = $source;
    }

    public function getSourceId(): string
    {
        return $this->sourceId;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function getSource(): string
    {
        return $this->source;
    }

    #[ArrayShape([
        'sourceId' => 'string',
        'text' => 'string',
        'category' => 'string',
        'source' => 'string',
    ])]
    public function jsonSerialize(): array
    {
        return [
            'sourceId' => $this->sourceId,
            'text' => $this->text,
            'category' => $this->category,
            'source' => $this->source,
        ];
    }
}
