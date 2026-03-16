<?php

namespace Delickate\QueryAnalyzer;

use Illuminate\Support\ServiceProvider;

class QueryAnalyzerServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Publish config
        $this->publishes([
            __DIR__.'/../config/query-analyzer.php' => config_path('query-analyzer.php'),
        ], 'config');

        // Publish stubs if needed
        $this->publishes([
            __DIR__.'/../stubs' => base_path('/'),
        ], 'query-analyzer');

        // Load views if your package has any
        //$this->loadViewsFrom(__DIR__.'/../resources/views', 'query-analyzer');

        // Register commands
        if ($this->app->runningInConsole()) {
            $this->commands([
                Commands\AnalyzeQueries::class,
            ]);
        }
    }

    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/query-analyzer.php', 'query-analyzer'
        );
    }
}