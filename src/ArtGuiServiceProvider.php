<?php

namespace Xden\ArtGui;

use Illuminate\Support\ServiceProvider;
use Xden\ArtGui\Contracts\CommandExecutor;
use Xden\ArtGui\Contracts\CommandRepository;
use Xden\ArtGui\Contracts\CommandTransformer;
use Xden\ArtGui\Contracts\CommandValidator;
use Xden\ArtGui\Repositories\ConfigCommandRepository;
use Xden\ArtGui\Services\CommandExecutorService;
use Xden\ArtGui\Services\CommandTransformerService;
use Xden\ArtGui\Services\CommandValidatorService;

class ArtGuiServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/artgui.php', 'artgui');

        if (config('artgui.enabled')) {
            $this->registerServices();
            $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        }
    }

    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../config/artgui.php' => config_path('artgui.php'),
        ], 'config');

        $this->publishes([
            __DIR__ . "/../stubs/artgui.css" => public_path('vendor/artgui/artgui.css'),
            __DIR__ . "/../stubs/artgui.js" => public_path('vendor/artgui/artgui.js'),
        ], 'assets');

        if (config('artgui.dev_mode', false)) {
            $this->loadViewsFrom(__DIR__.'/../resources/views', 'artgui');
        }
    }

    private function registerServices(): void
    {
        $this->app->bind(CommandRepository::class, ConfigCommandRepository::class);

        $this->app->singleton(CommandTransformer::class, CommandTransformerService::class);
        $this->app->singleton(CommandExecutor::class, CommandExecutorService::class);
        $this->app->singleton(CommandValidator::class, CommandValidatorService::class);
    }
}
