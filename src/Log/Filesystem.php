<?php

/*
 * This file is part of Laravel LogViewer.
 *
 * (c) Graham Campbell <graham@mineuk.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GrahamCampbell\LogViewer\Log;

use Illuminate\Filesystem\FileNotFoundException;
use Illuminate\Filesystem\Filesystem as Files;

/**
 * This is the filesystem class.
 *
 * @author Graham Campbell <graham@mineuk.com>
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
     * @param string $sapi
     * @param string $date
     *
     * @throws \GrahamCampbell\LogViewer\Log\FilesystemException
     *
     * @return string
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
     * @param string $sapi
     * @param string $date
     *
     * @throws \GrahamCampbell\LogViewer\Log\FilesystemException
     *
     * @return string
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
     * @param string $sapi
     * @param string $date
     *
     * @throws \GrahamCampbell\LogViewer\Log\FilesystemException
     *
     * @return void
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
     * @param string $sapi
     *
     * @return string[]
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
