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

namespace GrahamCampbell\LogViewer\Classes;

use Illuminate\Support\Facades\File;
use Psr\Log\LogLevel;
use ReflectionClass;

/**
 * This is the log class.
 *
 * @package    Laravel-LogViewer
 * @author     Graham Campbell
 * @copyright  Copyright 2014 Graham Campbell
 * @license    https://github.com/GrahamCampbell/Laravel-LogViewer/blob/master/LICENSE.md
 * @link       https://github.com/GrahamCampbell/Laravel-LogViewer
 */
class Log
{
    /**
     * The log storage path.
     *
     * @var string
     */
    protected $path;

    /**
     * The log sapi.
     *
     * @var string
     */
    protected $sapi;

    /**
     * The log date.
     *
     * @var string
     */
    protected $date;

    /**
     * The log level.
     *
     * @var string
     */
    protected $level;

    /**
     * The log levels.
     *
     * @var bool
     */
    protected $levels;

    /**
     * The log processed flag.
     *
     * @var bool
     */
    protected $processed;

    /**
     * The log state.
     *
     * @var bool
     */
    protected $empty;

    /**
     * The parsed log.
     *
     * @var array
     */
    protected $log;

    /**
     * Create a new instance.
     *
     * @param  string  $sapi
     * @param  string  $date
     * @param  string  $level
     */
    public function __construct($sapi, $date, $level = 'all')
    {
        $this->path = storage_path('logs');
        $this->sapi = $sapi;
        $this->date = $date;
        $this->level = $level;
    }

    /**
     * Open and parse the log.
     *
     * @return array
     */
    protected function parse()
    {
        $this->empty = true;
        $log = array();

        $pattern = "/\[\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}\].*/";

        $log_levels = $this->getLevels();

        $log_file = glob($this->path.'/log-'.$this->sapi.'*-'.$this->date.'.txt');

        if (!empty($log_file)) {
            $this->empty = false;
            $file = File::get($log_file[0]);

            preg_match_all($pattern, $file, $headings);
            $log_data = preg_split($pattern, $file);

            if ($log_data[0] < 1) {
                $trash = array_shift($log_data);
                unset($trash);
            }

            foreach ($headings as $h) {
                for ($i=0, $j = count($h); $i < $j; $i++) {
                    foreach ($log_levels as $ll) {
                        if ($this->level == $ll || $this->level == 'all') {
                            if (strpos(strtolower($h[$i]), strtolower('.'.$ll))) {
                                $log[] = array('level' => $ll, 'header' => $h[$i], 'stack' => $log_data[$i]);
                            }
                        }
                    }
                }
            }
        }

        unset($headings);
        unset($log_data);

        $log = array_reverse($log);

        return $log;
    }

    /**
     * Check if the log is empty.
     *
     * @return bool
     */
    public function isEmpty()
    {
        if (!$this->processed) {
            $this->get();
        }

        return $this->empty;
    }

    /**
     * Get the parsed log.
     *
     * @return array
     */
    public function get()
    {
        if (isset($this->log)) {
            $this->log = $this->parse();
            $this->processed = true;
        }

        return $this->log;
    }

    /**
     * Delete the log.
     *
     * @return bool
     */
    public function delete()
    {
        $log_file = glob($this->path.'/log-'.$this->sapi.'*-'.$this->date.'.txt');

        if (!empty($log_file)) {
            return File::delete($log_file[0]);
        }
    }

    /**
     * Get the log levels.
     *
     * @return array
     */
    public function getLevels()
    {
        if (isset($this->levels)) {
            $class = new ReflectionClass(new LogLevel);
            $this->levels = $class->getConstants()
        }

        return $this->levels;
    }
}
