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

namespace GrahamCampbell\Tests\LogViewer;

use GrahamCampbell\TestBench\AbstractLaravelTestCase;

/**
 * This is the abstract test case class.
 *
 * @package    Laravel-LogViewer
 * @author     Graham Campbell
 * @copyright  Copyright 2014 Graham Campbell
 * @license    https://github.com/GrahamCampbell/Laravel-LogViewer/blob/master/LICENSE.md
 * @link       https://github.com/GrahamCampbell/Laravel-LogViewer
 */
abstract class AbstractTestCase extends AbstractLaravelTestCase
{
    /**
     * Get the required service providers.
     *
     * @return array
     */
    protected function getRequiredServiceProviders()
    {
        return array(
            'Lightgear\Asset\AssetServiceProvider',
            'GrahamCampbell\Core\CoreServiceProvider'
        );
    }

    /**
     * Get the service provider class.
     *
     * @return string
     */
    protected function getServiceProviderClass()
    {
        return 'GrahamCampbell\LogViewer\LogViewerServiceProvider';
    }
}
