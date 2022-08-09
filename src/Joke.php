<?php

declare(strict_types=1);

namespace App;

use JsonSerializable;

class Joke implements JsonSerializable
{
    private string $id;
    private string $text;
    private string $category;
    private string $source;
    
    public function __construct(string $id, string $text, string $category, string $source)
    {
        $this->id = $id;
        $this->text = $text;
        $this->category = $category;
        $this->source = $source;
    }
    
    public function getJokeID() : int
    {
        return $this->id;
    }
    
    public function getJokeText() : string
    {
        return $this->text;
    }
    
    public function getJokeCategory() : string
    {
        return $this->category;
    }
    
    public function getJokeSource() : string
    {
        return $this->source;
    }
    
    public function jsonSerialize() : array
    {
        return [
            'id' => $this->id,
            'text' => $this->text,
            'category' => $this->category,
            'source' => $this->source,
        ];
    }
}
