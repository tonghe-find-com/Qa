<?php

namespace TypiCMS\Modules\Qas\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use TypiCMS\Modules\Core\Facades\TypiCMS;
use TypiCMS\Modules\Core\Observers\SlugObserver;
use TypiCMS\Modules\Qas\Composers\SidebarViewComposer;
use TypiCMS\Modules\Qas\Facades\Qas;
use TypiCMS\Modules\Qas\Models\Qa;
use TypiCMS\Modules\Qas\Models\Qacategory;
use TypiCMS\Modules\Qas\Facades\Qacategories;

class ModuleServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'typicms.qas');
        $this->mergeConfigFrom(__DIR__.'/../config/permissions.php', 'typicms.permissions');

        $modules = $this->app['config']['typicms']['modules'];
        $this->app['config']->set('typicms.modules', array_merge(['qas' => ['linkable_to_page']], $modules));

        $this->loadViewsFrom(null, 'qacategories');
        $this->loadViewsFrom(null, 'qas');

        $this->publishes([
            __DIR__.'/../database/migrations/create_qas_table.php.stub' => getMigrationFileName('create_qas_table'),
        ], 'migrations');

        $this->publishes([
            __DIR__.'/../../resources/views' => resource_path('views/vendor/qas'),
        ], 'views');

        AliasLoader::getInstance()->alias('Qacategories', Qacategories::class);
        AliasLoader::getInstance()->alias('Qas', Qas::class);

        // Observers
        Qacategory::observe(new SlugObserver());

        /*
         * Sidebar view composer
         */
        $this->app->view->composer('core::admin._sidebar', SidebarViewComposer::class);

        /*
         * Add the page in the view.
         */
        $this->app->view->composer('qas::public.*', function ($view) {
            $view->page = TypiCMS::getPageLinkedToModule('qas');
        });
    }

    public function register()
    {
        $app = $this->app;

        /*
         * Register route service provider
         */
        $app->register(RouteServiceProvider::class);

        $app->bind('Qacategories', Qacategory::class);
        $app->bind('Qas', Qa::class);
    }
}
