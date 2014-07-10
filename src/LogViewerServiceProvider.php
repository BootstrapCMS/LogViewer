<?php

/**
 * This file is part of Laravel LogViewer by Graham Campbell.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
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
 * @package    Laravel-LogViewer
 * @author     Graham Campbell
 * @copyright  Copyright 2014 Graham Campbell
 * @license    https://github.com/GrahamCampbell/Laravel-LogViewer/blob/master/LICENSE.md
 * @link       https://github.com/GrahamCampbell/Laravel-LogViewer
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
        $this->registerLogViewerController();
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
     * @return array
     */
    public function provides()
    {
        return array(
            //
        );
    }
}
