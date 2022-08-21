<?php

declare(strict_types=1);

namespace App;

use Exception;
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
        else $this->sourceId = $sourceId;

        if (empty($text)) throw new Exception('Empty text string.');
        else $this->text = $text;

        $this->category = $category;

        if (empty($source)) throw new Exception('Empty source string.');
        else $this->source = $source;
    }
    
    public function jsonSerialize() : array
    {
        return [
            'sourceId' => $this->sourceId,
            'text' => $this->text,
            'category' => $this->category,
            'source' => $this->source,
        ];
    }
}
