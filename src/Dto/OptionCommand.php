<?php

namespace Xden\ArtGui\Dto;

final readonly class OptionCommand
{
    public function __construct(
        public string $title,
        public ?string $name = null,
        public ?string $description = null,
        public ?string $shortcut = null,
        public bool $required = false,
        public bool $array = false,
        public bool $accept_value = false,
        public string|bool|int|float|array|null $default = null,
    )
    {
    }
}