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

namespace GrahamCampbell\LogViewer\Log;

use Illuminate\Filesystem\FileNotFoundException;
use Illuminate\Filesystem\Filesystem as Files;

/**
 * This is the filesystem class.
 *
 * @package    Laravel-LogViewer
 * @author     Graham Campbell
 * @copyright  Copyright 2014 Graham Campbell
 * @license    https://github.com/GrahamCampbell/Laravel-LogViewer/blob/master/LICENSE.md
 * @link       https://github.com/GrahamCampbell/Laravel-LogViewer
 */
class Filesystem
{
    /**
     * The files instance.
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $files;

    /**
     * The base storage path.
     *
     * @var string
     */
    protected $path;

    /**
     * Create a new instance.
     *
     * @param  \Illuminate\Filesystem\Filesystem  $files
     * @param  string  $path
     * @return void
     */
    public function __construct(Files $files, $path)
    {
        $this->files = $files;
        $this->path = $path;
    }

    /**
     * Get the log file path.
     *
     * @param  string  $sapi
     * @param  string  $date
     * @return string
     *
     * @throws \GrahamCampbell\LogViewer\Log\FilesystemException
     */
    protected function path($sapi, $date)
    {
        if ($files = glob($this->path.'/log-'.$sapi.'*-'.$date.'.txt')) {
            if ($file = array_get($files, 0)) {
                return $file;
            }
        }

        throw new FilesystemException('No usable logs found be located.');
    }

    /**
     * Read the log.
     *
     * @param  string  $sapi
     * @param  string  $date
     * @return string
     *
     * @throws \GrahamCampbell\LogViewer\Log\FilesystemException
     */
    public function read($sapi, $date)
    {
        try {
            return $this->files->get($this->path($sapi, $date));
        } catch (FileNotFoundException $e) {
            throw new FilesystemException('There was an reading the log.');
        }
    }

    /**
     * Delete the log.
     *
     * @param  string  $sapi
     * @param  string  $date
     * @return void
     *
     * @throws \GrahamCampbell\LogViewer\Log\FilesystemException
     */
    public function delete($sapi, $date)
    {
        if (!$this->files->delete($this->path($sapi, $date))) {
            throw new FilesystemException('There was an error deleting the log.');
        }
    }

    /**
     * List the log files.
     *
     * @param  string  $sapi
     * @return array
     */
    public function files($sapi)
    {
        return glob($this->path.'/log-'.$sapi.'*', GLOB_BRACE);
    }

    /**
     * Get the files instance.
     *
     * @return \Illuminate\Filesystem\Filesystem
     */
    public function getFiles()
    {
        return $this->files;
    }
}
