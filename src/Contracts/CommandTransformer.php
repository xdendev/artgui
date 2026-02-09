<?php

namespace Xden\ArtGui\Contracts;

use Symfony\Component\Console\Command\Command;
use Xden\ArtGui\Dto\Command as CommandDto;

interface CommandTransformer
{
    public function prepareCommands(array $groupCommands): array;
    public function commandToDto(string $commandName): CommandDto;
    public function extractArguments(Command $command): ?array;
    public function extractOptions(Command $command): ?array;
}