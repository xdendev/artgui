<?php

namespace Xden\ArtGui\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Psr\Log\NullLogger;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Xden\ArtGui\Services\CommandExecutorService;

final class CommandExecutorServiceTest extends TestCase
{
    public function test_prepare_parameters_maps_options_and_splits_array_arguments(): void
    {
        $command = (new Command('demo'))
            ->addArgument('user', InputArgument::REQUIRED)
            ->addArgument('ids', InputArgument::IS_ARRAY)
            ->addOption('bank', null, InputOption::VALUE_REQUIRED)
            ->addOption('dry-run', null, InputOption::VALUE_NONE);

        $params = (new CommandExecutorService(new NullLogger()))->prepareParameters($command, [
            'user' => '42',
            'ids' => ' 1  2 3 ',
            'bank' => 'vtb',
            'dry-run' => '1',
            'empty' => '',
            'missing' => null,
        ]);

        $this->assertSame([
            'user' => '42',
            'ids' => ['1', '2', '3'],
            '--bank' => 'vtb',
            '--dry-run' => '1',
        ], $params);
    }
}
