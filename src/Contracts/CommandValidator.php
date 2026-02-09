<?php

namespace Xden\ArtGui\Contracts;

use Symfony\Component\Console\Command\Command;

interface CommandValidator
{
    public function findCommandOrFail(string $name): Command;
    public function buildRules(Command $command): array;
}