<?php

/*
 * This file is part of Laravel LogViewer.
 *
 * (c) Graham Campbell <graham@cachethq.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GrahamCampbell\Tests\LogViewer;

use GrahamCampbell\TestBench\Traits\ServiceProviderTestCaseTrait;

/**
 * This is the service provider test class.
 *
 * @author Graham Campbell <graham@cachethq.io>
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
