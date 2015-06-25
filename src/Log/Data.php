<?php

/*
 * This file is part of Laravel LogViewer.
 *
 * (c) Graham Campbell <graham@alt-three.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GrahamCampbell\LogViewer\Log;

use Psr\Log\LogLevel;
use ReflectionClass;

/**
 * This is the data class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class Data
{
    /**
     * The cached log levels.
     *
     * @var string[]
     */
    protected $levels;

    /**
     * Get the log levels.
     *
     * @return string[]
     */
    public function levels()
    {
        if (!$this->levels) {
            $class = new ReflectionClass(new LogLevel());
            $this->levels = $class->getConstants();
        }

        return $this->levels;
    }
}
