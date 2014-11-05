<?php

/**
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

namespace GrahamCampbell\LogViewer\Log;

use Psr\Log\LogLevel;
use ReflectionClass;

/**
 * This is the data class.
 *
 * @author    Graham Campbell <graham@mineuk.com>
 * @copyright 2014 Graham Campbell
 * @license   <https://github.com/GrahamCampbell/Laravel-LogViewer/blob/master/LICENSE.md> Apache 2.0
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
