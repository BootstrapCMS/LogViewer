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

namespace GrahamCampbell\LogViewer;

use GrahamCampbell\LogViewer\Log\Data;
use GrahamCampbell\LogViewer\Log\Factory;
use GrahamCampbell\LogViewer\Log\Filesystem;

/**
 * This is the log viewer class.
 *
 * @author    Graham Campbell <graham@mineuk.com>
 * @copyright 2014 Graham Campbell
 * @license   <https://github.com/GrahamCampbell/Laravel-LogViewer/blob/master/LICENSE.md> Apache 2.0
 */
class LogViewer
{
    /**
     * The factory instance.
     *
     * @var \GrahamCampbell\LogViewer\Log\Factory
     */
    protected $factory;

    /**
     * The filesystem instance.
     *
     * @var \GrahamCampbell\LogViewer\Log\Filesystem
     */
    protected $filesystem;

    /**
     * The data instance.
     *
     * @var \GrahamCampbell\LogViewer\Log\Data
     */
    protected $data;

    /**
     * Create a new instance.
     *
     * @param \GrahamCampbell\LogViewer\Log\Factory    $factory
     * @param \GrahamCampbell\LogViewer\Log\Filesystem $filesystem
     * @param \GrahamCampbell\LogViewer\Log\Data       $data
     *
     * @return void
     */
    public function __construct(Factory $factory, Filesystem $filesystem, Data $data)
    {
        $this->factory = $factory;
        $this->filesystem = $filesystem;
        $this->data = $data;
    }

    /**
     * Get the log data.
     *
     * @param string $sapi
     * @param string $date
     * @param string $level
     *
     * @return array
     */
    public function data($sapi, $date, $level = 'all')
    {
        return $this->factory->make($sapi, $date, $level)->data();
    }

    /**
     * Delete the log.
     *
     * @param string $sapi
     * @param string $date
     *
     * @return void
     */
    public function delete($sapi, $date)
    {
        return $this->filesystem->delete($sapi, $date);
    }

    /**
     * List the log files.
     *
     * @return string[]
     */
    public function logs()
    {
        $logs = [];

        foreach ($this->data->sapis() as $real => $human) {
            $logs[$real]['sapi'] = $human;

            $logs[$real]['logs'] = $this->filesystem->files($real);

            if (is_array($logs[$real]['logs']) && !empty($logs[$real]['logs'])) {
                $logs[$real]['logs'] = array_reverse($logs[$real]['logs']);
                foreach ($logs[$real]['logs'] as &$file) {
                    $file = preg_replace('/.*(\d{4}-\d{2}-\d{2}).*/', '$1', basename($file));
                }
            } else {
                unset($logs[$real]);
            }
        }

        return $logs;
    }

    /**
     * Get the log levels.
     *
     * @return string[]
     */
    public function levels()
    {
        return $this->data->levels();
    }

    /**
     * Get the different sapis.
     *
     * @return string[]
     */
    public function sapis()
    {
        return $this->data->sapis();
    }

    /**
     * Get the current sapi.
     *
     * @return string
     */
    public function sapi()
    {
        return $this->data->sapi();
    }

    /**
     * Get the factory instance.
     *
     * @return \GrahamCampbell\LogViewer\Log\Factory
     */
    public function getFactory()
    {
        return $this->factory;
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

    /**
     * Get the data instance.
     *
     * @return \GrahamCampbell\LogViewer\Log\Data
     */
    public function getData()
    {
        return $this->data;
    }
}
