<?php

namespace Xden\ArtGui\Contracts;

use Symfony\Component\Console\Command\Command;
use Xden\ArtGui\Dto\ExecuteCommandResults;

interface CommandExecutor
{
    public function execute(Command $command, array $validatedData): ExecuteCommandResults;
    public function prepareParameters(Command $command, array $data): array;
}