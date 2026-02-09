<?php

namespace Xden\ArtGui\Services;

use Illuminate\Support\Facades\Artisan;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Output\BufferedOutput;
use Throwable;
use Xden\ArtGui\Contracts\CommandExecutor;
use Xden\ArtGui\Dto\ExecuteCommandResults;

final class CommandExecutorService implements CommandExecutor
{
    public function __construct(
        private LoggerInterface $logger,
    )
    {
    }

    public function execute(Command $command, array $validatedData): ExecuteCommandResults
    {
        $params = $this->prepareParameters($command, $validatedData);
        $commandName = $command->getName();

        $output = new BufferedOutput(BufferedOutput::VERBOSITY_NORMAL, true);

        try {
            $status = Artisan::call($commandName, $params, $output);
            $outputText = $output->fetch();
        } catch (Throwable $exception) {
            $this->logger->error('Artisan command failed', [
                'command' => $commandName,
                'error' => $exception->getMessage(),
                'trace' => $exception->getTraceAsString(),
            ]);

            $status = (int) ($exception->getCode() > 0 ? $exception->getCode() : 500);
            $outputText = $exception->getMessage();
        }

        return new ExecuteCommandResults($status, $outputText, $commandName);
    }

    public function prepareParameters(Command $command, array $data): array
    {
        $data = array_filter($data, static fn($value) => $value !== null && $value !== '');
        $options = array_keys($command->getDefinition()->getOptions());

        $params = [];

        foreach ($data as $key => $value) {
            if (in_array($key, $options, true)) {
                $key = "--{$key}";
            }

            $params[$key] = $value;
        }

        return $params;
    }
}