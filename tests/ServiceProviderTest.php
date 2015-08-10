<?php

/*
 * This file is part of Laravel LogViewer.
 *
 * (c) Graham Campbell <graham@alt-three.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GrahamCampbell\Tests\LogViewer;

use GrahamCampbell\LogViewer\LogViewer;
use GrahamCampbell\LogViewer\Log\Data;
use GrahamCampbell\LogViewer\Log\Factory;
use GrahamCampbell\LogViewer\Log\Filesystem;
use GrahamCampbell\TestBenchCore\ServiceProviderTrait;

/**
 * This is the service provider test class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class ServiceProviderTest extends AbstractTestCase
{
    use ServiceProviderTrait;

    public function testLogDataIsInjectable()
    {
        $this->assertIsInjectable(Data::class);
    }

    public function testLogFilesystemIsInjectable()
    {
        $this->assertIsInjectable(Filesystem::class);
    }

    public function testLogFactoryIsInjectable()
    {
        $this->assertIsInjectable(Factory::class);
    }

    public function testLogViewerIsInjectable()
    {
        $this->assertIsInjectable(LogViewer::class);
    }
}
