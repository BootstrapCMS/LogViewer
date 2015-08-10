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

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Filesystem\Filesystem as Files;

/**
 * This is the filesystem class.
 *
 * @author Graham Campbell <graham@alt-three.com>
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
     * @param \Illuminate\Filesystem\Filesystem $files
     * @param string                            $path
     *
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
     * @param string $date
     *
     * @throws \GrahamCampbell\LogViewer\Log\FilesystemException
     *
     * @return string
     */
    protected function path($date)
    {
        $path = $this->path.'/laravel-'.$date.'.log';

        if ($this->files->exists($path)) {
            return realpath($path);
        }

        throw new FilesystemException('The log(s) could not be located.');
    }

    /**
     * Read the log.
     *
     * @param string $date
     *
     * @throws \GrahamCampbell\LogViewer\Log\FilesystemException
     *
     * @return string
     */
    public function read($date)
    {
        try {
            return $this->files->get($this->path($date));
        } catch (FileNotFoundException $e) {
            throw new FilesystemException('There was an reading the log.');
        }
    }

    /**
     * Delete the log.
     *
     * @param string $date
     *
     * @throws \GrahamCampbell\LogViewer\Log\FilesystemException
     *
     * @return void
     */
    public function delete($date)
    {
        if (!$this->files->delete($this->path($date))) {
            throw new FilesystemException('There was an error deleting the log.');
        }
    }

    /**
     * List the log files.
     *
     * @return string[]
     */
    public function files()
    {
        return glob($this->path.'/laravel-*.log', GLOB_BRACE);
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
