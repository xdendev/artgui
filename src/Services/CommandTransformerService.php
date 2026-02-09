<?php

namespace Xden\ArtGui\Services;

use Illuminate\Support\Facades\Artisan;
use Xden\ArtGui\Contracts\CommandTransformer as Contract;
use Illuminate\Support\Str;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Xden\ArtGui\Dto\ArgumentCommand;
use Xden\ArtGui\Dto\Command as CommandDto;
use Xden\ArtGui\Dto\CommandUnknown as CommandUnknownDto;
use Xden\ArtGui\Dto\OptionCommand;

final class CommandTransformerService implements Contract
{
    public function __construct(
        private ?array $defined = null
    )
    {
    }

    public function prepareCommands(array $groupCommands): array
    {
        $groupCommands = $this->renameKeys($groupCommands);

        $commands = [];

        foreach ($groupCommands as $gKey => $group) {
            foreach ($group as $cKey => $command) {
                $commands[$gKey][$cKey] = $this->commandToDto($command);
            }

            if (empty($commands[$gKey])) {
                unset($commands[$gKey]);
                continue;
            }

            $commands[$gKey] = array_values($commands[$gKey]);
        }

        return $commands;
    }

    public function commandToDto(string $commandName): CommandDto
    {
        $command = $this->getCommand($commandName);

        if (!$command) {
            return CommandUnknownDto::unknown($commandName);
        }

        return new CommandDto(
            $command->getName(),
            $command->getDescription(),
            $command->getSynopsis(),
            $this->extractArguments($command),
            $this->extractOptions($command),
        );
    }

    public function extractOptions(Command $command): ?array
    {
        $definition = $command->getDefinition();

        $options = array_map(function (InputOption $option) {
            return new OptionCommand(
                Str::of($option->getName())->snake()->replace('_', ' ')->title()->__toString(),
                $option->getName(),
                $option->getDescription(),
                $option->getShortcut(),
                $option->isValueRequired(),
                $option->isArray(),
                $option->acceptValue(),
                $option->getDefault() === null ? null : $option->getDefault()
            );
        }, $definition->getOptions());

        return empty($options) ? null : array_values($options);
    }

    public function extractArguments(Command $command): ?array
    {
        $definition = $command->getDefinition();

        $arguments = array_map(function (InputArgument $argument) {
            return new ArgumentCommand(
                Str::of($argument->getName())->snake()->replace('_', ' ')->title()->__toString(),
                $argument->getName(),
                $argument->getDescription(),
                empty($default = $argument->getDefault()) ? null : $default,
                $argument->isRequired(),
                $argument->isArray(),
            );
        }, $definition->getArguments());

        return empty($arguments) ? null : array_values($arguments);
    }

    private function renameKeys(array $array): array
    {
        $keys = array_map(function ($key) {
            return Str::title($key);
        }, array_keys($array));

        return array_combine($keys, array_values($array));
    }

    private function getCommand(string $commandName): ?Command
    {
        if ($this->defined === null) {
            $this->defined = Artisan::all();
        }

        return $this->defined[$commandName] ?? null;
    }
}