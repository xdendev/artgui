<?php

namespace Xden\ArtGui\Dto;

final readonly class ArgumentCommand
{
    public function __construct(
        public string $title,
        public string $name,
        public ?string $description = null,
        public string|bool|int|float|array|null $default = null,
        public bool $required = false,
        public bool $array = false,
    )
    {
    }
}