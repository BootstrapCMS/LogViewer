<?php

/*
 * This file is part of Laravel LogViewer.
 *
 * (c) Graham Campbell <graham@mineuk.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GrahamCampbell\LogViewer;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Lightgear\Asset\Asset;

/**
 * This is the log viewer service provider class.
 *
 * @author Graham Campbell <graham@mineuk.com>
 */
class LogViewerServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->package('graham-campbell/logviewer', 'graham-campbell/logviewer', __DIR__);

        $this->setupAssets($this->app['asset']);

        $this->setupRoutes($this->app['router']);
    }

    /**
     * Setup the assets.
     *
     * @param \Lightgear\Asset $asset
     *
     * @return void
     */
    protected function setupAssets(Asset $asset)
    {
        $asset->registerStyles(['graham-campbell/logviewer/src/assets/css/logviewer.css'], '', 'logviewer');
        $asset->registerScripts(['graham-campbell/logviewer/src/assets/js/logviewer.js'], '', 'logviewer');
    }

    /**
     * Setup the routes.
     *
     * @param \Illuminate\Routing\Router $router
     *
     * @return void
     */
    protected function setupRoutes(Router $router)
    {
        $router->group(['namespace' => 'GrahamCampbell\LogViewer\Http\Controllers'], function (Router $router) {
            require __DIR__.'/Http/routes.php';
        });
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerLogData();
        $this->registerLogFilesystem();
        $this->registerLogFactory();

        $this->registerLogViewer();

        $this->registerLogViewerController();
    }

    /**
     * Register the log data class.
     *
     * @return void
     */
    protected function registerLogData()
    {
        $this->app->singleton('logviewer.data', function () {
            return new Log\Data();
        });

        $this->app->alias('logviewer.data', 'GrahamCampbell\LogViewer\Log\Data');
    }

    /**
     * Register the log filesystem class.
     *
     * @return void
     */
    protected function registerLogFilesystem()
    {
        $this->app->singleton('logviewer.filesystem', function ($app) {
            $files = $app['files'];
            $path = $app['path.storage'].'/logs';

            return new Log\Filesystem($files, $path);
        });

        $this->app->alias('logviewer.filesystem', 'GrahamCampbell\LogViewer\Log\Filesystem');
    }

    /**
     * Register the log factory class.
     *
     * @return void
     */
    protected function registerLogFactory()
    {
        $this->app->singleton('logviewer.factory', function ($app) {
            $filesystem = $app['logviewer.filesystem'];
            $levels = $app['logviewer.data']->levels();

            return new Log\Factory($filesystem, $levels);
        });

        $this->app->alias('logviewer.factory', 'GrahamCampbell\LogViewer\Log\Factory');
    }

    /**
     * Register the log data class.
     *
     * @return void
     */
    protected function registerLogViewer()
    {
        $this->app->singleton('logviewer', function ($app) {
            $factory = $app['logviewer.factory'];
            $filesystem = $app['logviewer.filesystem'];
            $data = $app['logviewer.data'];

            return new LogViewer($factory, $filesystem, $data);
        });

        $this->app->alias('logviewer', 'GrahamCampbell\LogViewer\LogViewer');
    }

    /**
     * Register the log viewer controller class.
     *
     * @return void
     */
    protected function registerLogViewerController()
    {
        $this->app->bind('GrahamCampbell\LogViewer\Http\Controllers\LogViewerController', function ($app) {
            $perPage = $app['config']['graham-campbell/logviewer::per_page'];
            $middleware = $app['config']['graham-campbell/logviewer::middleware'];

            return new Http\Controllers\LogViewerController($perPage, $middleware);
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return string[]
     */
    public function provides()
    {
        return [
            'logviewer',
            'logviewer.data',
            'logviewer.factory',
            'logviewer.filesystem',
        ];
    }
}
