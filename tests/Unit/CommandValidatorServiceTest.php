<?php

namespace Xden\ArtGui\Tests\Unit;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Xden\ArtGui\Repositories\ConfigCommandRepository;
use Xden\ArtGui\Services\CommandValidatorService;
use Xden\ArtGui\Tests\TestCase;

final class CommandValidatorServiceTest extends TestCase
{
    public function test_value_required_option_is_not_required(): void
    {
        $command = (new Command('demo'))
            ->addOption('bank', null, InputOption::VALUE_REQUIRED)
            ->addOption('ids', null, InputOption::VALUE_REQUIRED | InputOption::VALUE_IS_ARRAY)
            ->addOption('dry-run', null, InputOption::VALUE_NONE);

        $rules = (new CommandValidatorService(new ConfigCommandRepository()))->buildRules($command);

        $this->assertSame(['nullable', 'string'], $rules['bank']);
        $this->assertSame(['nullable', 'array'], $rules['ids']);
        $this->assertSame(['nullable', 'boolean'], $rules['dry-run']);
    }

    public function test_argument_requirement_follows_definition(): void
    {
        $command = (new Command('demo'))
            ->addArgument('user', InputArgument::REQUIRED)
            ->addArgument('extra', InputArgument::OPTIONAL);

        $rules = (new CommandValidatorService(new ConfigCommandRepository()))->buildRules($command);

        $this->assertSame(['required'], $rules['user']);
        $this->assertSame(['nullable'], $rules['extra']);
    }
}
