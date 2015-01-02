<?php

/*
 * This file is part of Laravel LogViewer.
 *
 * (c) Graham Campbell <graham@mineuk.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GrahamCampbell\LogViewer;

use GrahamCampbell\LogViewer\Log\Data;
use GrahamCampbell\LogViewer\Log\Factory;
use GrahamCampbell\LogViewer\Log\Filesystem;

/**
 * This is the log viewer class.
 *
 * @author Graham Campbell <graham@mineuk.com>
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
