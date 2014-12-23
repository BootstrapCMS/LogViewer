<?php

/*
 * This file is part of Laravel LogViewer by Graham Campbell.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at http://bit.ly/UWsjkb.
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace GrahamCampbell\LogViewer;

use Illuminate\Support\ServiceProvider;

/**
 * This is the log viewer service provider class.
 *
 * @author    Graham Campbell <graham@mineuk.com>
 * @copyright 2014 Graham Campbell
 * @license   <https://github.com/GrahamCampbell/Laravel-LogViewer/blob/master/LICENSE.md> Apache 2.0
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

        include __DIR__.'/routes.php';
        include __DIR__.'/assets.php';
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
        $this->app->bindShared('logviewer.data', function () {
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
        $this->app->bindShared('logviewer.filesystem', function ($app) {
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
        $this->app->bindShared('logviewer.factory', function ($app) {
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
        $this->app->bindShared('logviewer', function ($app) {
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
        $this->app->bind('GrahamCampbell\LogViewer\Controllers\LogViewerController', function ($app) {
            $perPage = $app['config']['graham-campbell/logviewer::per_page'];
            $filters = $app['config']['graham-campbell/logviewer::filters'];

            return new Controllers\LogViewerController($perPage, $filters);
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return string[]
     */
    public function provides()
    {
        return array(
            'logviewer',
            'logviewer.data',
            'logviewer.factory',
            'logviewer.filesystem',
        );
    }
}
