<?php

namespace Xden\ArtGui\Dto;

readonly class Command
{
    public function __construct(
        public string $name,
        public ?string $description = null,
        public ?string $synopsis = null,
        public ?array $arguments = null,
        public ?array $options = null,
    )
    {
    }
}