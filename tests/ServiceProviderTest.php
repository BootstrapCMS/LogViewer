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

namespace GrahamCampbell\Tests\LogViewer;

use GrahamCampbell\TestBench\Traits\ServiceProviderTestCaseTrait;

/**
 * This is the service provider test class.
 *
 * @author    Graham Campbell <graham@mineuk.com>
 * @copyright 2014 Graham Campbell
 * @license   <https://github.com/GrahamCampbell/Laravel-LogViewer/blob/master/LICENSE.md> Apache 2.0
 */
class ServiceProviderTest extends AbstractTestCase
{
    use ServiceProviderTestCaseTrait;

    public function testLogDataIsInjectable()
    {
        $this->assertIsInjectable('GrahamCampbell\LogViewer\Log\Data');
    }

    public function testLogFilesystemIsInjectable()
    {
        $this->assertIsInjectable('GrahamCampbell\LogViewer\Log\Filesystem');
    }

    public function testLogFactoryIsInjectable()
    {
        $this->assertIsInjectable('GrahamCampbell\LogViewer\Log\Factory');
    }

    public function testLogViewerIsInjectable()
    {
        $this->assertIsInjectable('GrahamCampbell\LogViewer\LogViewer');
    }
}
