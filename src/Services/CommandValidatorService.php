<?php

namespace Xden\ArtGui\Services;

use Illuminate\Support\Facades\Artisan;
use Symfony\Component\Console\Command\Command;
use Xden\ArtGui\Contracts\CommandRepository;
use Xden\ArtGui\Contracts\CommandValidator;
use Xden\ArtGui\Exceptions\CommandNotFoundException;

final class CommandValidatorService implements CommandValidator
{

    public function __construct(private CommandRepository $commandRepository)
    {
    }

    public function findCommandOrFail(string $name): Command
    {
        if (!$this->commandRepository->commandExists($name)) {
            throw new CommandNotFoundException($name);
        }

        $commands = Artisan::all();

        if (!isset($commands[$name])) {
            throw new CommandNotFoundException($name);
        }

        return $commands[$name];
    }

    public function buildRules(Command $command): array
    {
        $rules = [];

        foreach ($command->getDefinition()->getArguments() as $argument) {
            $rules[$argument->getName()] = [
                $argument->isRequired() ? 'required' : 'nullable',
            ];
        }

        foreach ($command->getDefinition()->getOptions() as $option) {
            $rules[$option->getName()] = [
                $option->isValueRequired() ? 'required' : 'nullable',
                $option->acceptValue() ? ($option->isArray() ? 'array' : 'string') : 'boolean',
            ];
        }

        return $rules;
    }
}