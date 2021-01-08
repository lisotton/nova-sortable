<?php

namespace OptimistDigital\NovaSortable;

use Laravel\Nova\Nova;
use Laravel\Nova\Events\ServingNova;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use OptimistDigital\NovaTranslationsLoader\LoadsNovaTranslations;

class ToolServiceProvider extends ServiceProvider
{
    use LoadsNovaTranslations;

    public function boot()
    {
        $this->app->booted(function () {
            $this->routes();
        });

        Nova::serving(function (ServingNova $event) {
            Nova::script('nova-sortable', __DIR__ . '/../dist/js/tool.js');
        });

        $this->loadTranslations(__DIR__ . '/../resources/lang', 'nova-sortable', true);
    }

    /**
     * Register the tool's routes.
     *
     * @return void
     */
    protected function routes()
    {
        if ($this->app->routesAreCached()) return;

        Route::middleware(['nova'])
            ->prefix('nova-vendor/nova-sortable')
            ->namespace('\OptimistDigital\NovaSortable\Http\Controllers')
            ->group(__DIR__ . '/../routes/api.php');
    }
}
