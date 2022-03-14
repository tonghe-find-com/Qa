<?php

namespace TypiCMS\Modules\Qas\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use TypiCMS\Modules\Core\Facades\TypiCMS;
use TypiCMS\Modules\Qas\Http\Controllers\Category\AdminController as CategoryAdminController;
use TypiCMS\Modules\Qas\Http\Controllers\Item\AdminController;
use TypiCMS\Modules\Qas\Http\Controllers\Category\ApiController as CategoryApiController;
use TypiCMS\Modules\Qas\Http\Controllers\Item\ApiController;
use TypiCMS\Modules\Qas\Http\Controllers\PublicController;

class RouteServiceProvider extends ServiceProvider
{
    public function map()
    {
        /*
         * Front office routes
         */
        if ($page = TypiCMS::getPageLinkedToModule('qas')) {
            $middleware = $page->private ? ['public', 'auth'] : ['public'];
            foreach (locales() as $lang) {
                if ($page->isPublished($lang) && $uri = $page->uri($lang)) {
                    Route::middleware($middleware)->prefix($uri)->name($lang.'::')->group(function (Router $router) {
                        $router->get('/', [PublicController::class, 'index'])->name('index-qas');
                        $router->get('{slug}', [PublicController::class, 'show'])->name('qa');
                    });
                }
            }
        }

        /*
         * Admin routes
         */
        Route::middleware('admin')->prefix('admin')->name('admin::')->group(function (Router $router) {
            $router->get('qacategories', [CategoryAdminController::class, 'index'])->name('index-qacategories')->middleware('can:read qacategories');
            $router->get('qacategories/export', [CategoryAdminController::class, 'export'])->name('admin::export-qacategories')->middleware('can:read qacategories');
            $router->get('qacategories/create', [CategoryAdminController::class, 'create'])->name('create-qacategory')->middleware('can:create qacategories');
            $router->get('qacategories/{qacategory}/edit', [CategoryAdminController::class, 'edit'])->name('edit-qacategory')->middleware('can:read qacategories');
            $router->post('qacategories', [CategoryAdminController::class, 'store'])->name('store-qacategory')->middleware('can:create qacategories');
            $router->put('qacategories/{qacategory}', [CategoryAdminController::class, 'update'])->name('update-qacategory')->middleware('can:update qacategories');
        });

        /*
         * API routes
         */
        Route::middleware(['api', 'auth:api'])->prefix('api')->group(function (Router $router) {
            $router->get('qacategories', [CategoryApiController::class, 'index'])->middleware('can:read qacategories');
            $router->patch('qacategories/{qacategory}', [CategoryApiController::class, 'updatePartial'])->middleware('can:update qacategories');
            $router->delete('qacategories/{qacategory}', [CategoryApiController::class, 'destroy'])->middleware('can:delete qacategories');
        });

        /*
         * Admin routes
         */
        Route::middleware('admin')->prefix('admin')->name('admin::')->group(function (Router $router) {
            $router->get('qas', [AdminController::class, 'index'])->name('index-qas')->middleware('can:read qas');
            $router->get('qas/export', [AdminController::class, 'export'])->name('admin::export-qas')->middleware('can:read qas');
            $router->get('qas/create', [AdminController::class, 'create'])->name('create-qa')->middleware('can:create qas');
            $router->get('qas/{qa}/edit', [AdminController::class, 'edit'])->name('edit-qa')->middleware('can:read qas');
            $router->post('qas', [AdminController::class, 'store'])->name('store-qa')->middleware('can:create qas');
            $router->put('qas/{qa}', [AdminController::class, 'update'])->name('update-qa')->middleware('can:update qas');
        });

        /*
         * API routes
         */
        Route::middleware(['api', 'auth:api'])->prefix('api')->group(function (Router $router) {
            $router->get('qas', [ApiController::class, 'index'])->middleware('can:read qas');
            $router->patch('qas/{qa}', [ApiController::class, 'updatePartial'])->middleware('can:update qas');
            $router->delete('qas/{qa}', [ApiController::class, 'destroy'])->middleware('can:delete qas');
        });
    }
}
