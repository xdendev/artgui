<?php

namespace Xden\ArtGui\Contracts;

interface CommandRepository
{
    public function getCommands(): array;

    public function commandExists(string $command): bool;
}