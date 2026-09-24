<?php

namespace Xden\ArtGui\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use Xden\ArtGui\ArtGuiServiceProvider;

abstract class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [ArtGuiServiceProvider::class];
    }
}
