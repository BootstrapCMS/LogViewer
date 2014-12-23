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

namespace GrahamCampbell\LogViewer\Log;

/**
 * This is the factory class.
 *
 * @author    Graham Campbell <graham@mineuk.com>
 * @copyright 2014 Graham Campbell
 * @license   <https://github.com/GrahamCampbell/Laravel-LogViewer/blob/master/LICENSE.md> Apache 2.0
 */
class Factory
{
    /**
     * The filesystem instance.
     *
     * @var \GrahamCampbell\LogViewer\Log\Filesystem
     */
    protected $filesystem;

    /**
     * The log levels.
     *
     * @var array
     */
    protected $levels;

    /**
     * Create a new instance.
     *
     * @param \GrahamCampbell\LogViewer\Log\Filesystem $filesystem
     * @param string[]                                 $levels
     */
    public function __construct(Filesystem $filesystem, array $levels)
    {
        $this->filesystem = $filesystem;
        $this->levels = $levels;
    }

    /**
     * Get the log instance.
     *
     * @param string $sapi
     * @param string $date
     * @param string $level
     *
     * @return \GrahamCampbell\LogViewer\Log\Log
     */
    public function make($sapi, $date, $level = 'all')
    {
        $raw = $this->filesystem->read($sapi, $date);
        $levels = $this->levels;

        return new Log($raw, $levels, $level);
    }

    /**
     * Get the filesystem instance.
     *
     * @return \GrahamCampbell\Logviewer\Log\Filesystem
     */
    public function getFilesystem()
    {
        return $this->filesystem;
    }
}
