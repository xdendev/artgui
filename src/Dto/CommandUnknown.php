<?php

namespace Xden\ArtGui\Dto;

final readonly class CommandUnknown extends Command
{
    private function __construct(string $name)
    {
        parent::__construct($name);
    }

    public static function unknown(string $name): CommandUnknown
    {
        return new self($name);
    }
}