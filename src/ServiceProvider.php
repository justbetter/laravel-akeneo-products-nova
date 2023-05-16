<?php

namespace JustBetter\AkeneoProductsNova;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Laravel\Nova\Nova;

class ServiceProvider extends BaseServiceProvider
{
    public function register(): void
    {
        $this->registerConfig();
    }

    protected function registerConfig(): static
    {
        $this->mergeConfigFrom(__DIR__.'/../config/akeneo-products-nova.php', 'akeneo-products-nova');

        return $this;
    }

    public function boot(): void
    {
        $this
            ->bootConfig()
            ->bootNova();
    }

    protected function bootConfig(): static
    {
        $this->publishes([
            __DIR__.'/../config/akeneo-products-nova.php' => config_path('akeneo-products-nova.php'),
        ], 'config');

        return $this;
    }

    protected function bootNova(): static
    {
        Nova::resources(
            config('akeneo-products-nova.resources')
        );

        return $this;
    }
}
