<?php

namespace Xden\ArtGui\Repositories;

use Illuminate\Support\Arr;
use Xden\ArtGui\Contracts\CommandRepository;

final class ConfigCommandRepository implements CommandRepository
{
    public function getCommands(): array
    {
        return config('artgui.commands', []);
    }

    public function commandExists(string $command): bool
    {
        return in_array($command, Arr::flatten(config('artgui.commands', [])));
    }
}