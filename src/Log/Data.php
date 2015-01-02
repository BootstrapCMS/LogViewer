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

use Psr\Log\LogLevel;
use ReflectionClass;

/**
 * This is the data class.
 *
 * @author Graham Campbell <graham@mineuk.com>
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

    /**
     * Get the different sapis.
     *
     * @return string[]
     */
    public function sapis()
    {
        return [
            'apache' => 'Apache',
            'fpm'    => 'Nginx',
            'cgi'    => 'CGI',
            'srv'    => 'HHVM',
            'cli'    => 'CLI',
        ];
    }

    /**
     * Get the current sapi.
     *
     * @throws \Exception
     *
     * @return string
     */
    public function sapi()
    {
        $real = php_sapi_name();

        foreach (array_keys($this->sapis()) as $sapi) {
            if (preg_match('/'.$sapi.'.*/', $real)) {
                return $sapi;
            }
        }

        throw new \Exception('Your sever is unknown!');
    }
}
