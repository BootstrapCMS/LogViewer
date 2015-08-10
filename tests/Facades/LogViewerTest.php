<?php

/*
 * This file is part of Laravel LogViewer.
 *
 * (c) Graham Campbell <graham@alt-three.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GrahamCampbell\Tests\LogViewer\Facades;

use GrahamCampbell\LogViewer\Facades\LogViewer as LogViewerFacade;
use GrahamCampbell\LogViewer\LogViewer;
use GrahamCampbell\TestBenchCore\FacadeTrait;
use GrahamCampbell\Tests\LogViewer\AbstractTestCase;

/**
 * This is the logviewer facade test class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class LogViewerTest extends AbstractTestCase
{
    use FacadeTrait;

    /**
     * Get the facade accessor.
     *
     * @return string
     */
    protected function getFacadeAccessor()
    {
        return 'logviewer';
    }

    /**
     * Get the facade class.
     *
     * @return string
     */
    protected function getFacadeClass()
    {
        return LogViewerFacade::class;
    }

    /**
     * Get the facade route.
     *
     * @return string
     */
    protected function getFacadeRoot()
    {
        return LogViewer::class;
    }
}
