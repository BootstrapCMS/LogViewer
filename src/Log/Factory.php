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

/**
 * This is the factory class.
 *
 * @author Graham Campbell <graham@alt-three.com>
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
     * @param string $date
     * @param string $level
     *
     * @return \GrahamCampbell\LogViewer\Log\Log
     */
    public function make($date, $level = 'all')
    {
        $raw = $this->filesystem->read($date);
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
