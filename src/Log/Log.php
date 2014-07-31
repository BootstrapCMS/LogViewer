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

/**
 * This is the log class.
 *
 * @author    Graham Campbell <graham@mineuk.com>
 * @copyright 2014 Graham Campbell
 * @license   <https://github.com/GrahamCampbell/Laravel-LogViewer/blob/master/LICENSE.md> Apache 2.0
 */
class Log
{
    /**
     * The raw log contents.
     *
     * @var string
     */
    protected $raw;

    /**
     * The available log levels.
     *
     * @var string[]
     */
    protected $levels;

    /**
     * The selected log level.
     *
     * @var string
     */
    protected $level;

    /**
     * The processed log data.
     *
     * @var array
     */
    protected $data;

    /**
     * Create a new instance.
     *
     * @param string   $raw
     * @param string[] $levels
     * @param string   $level
     */
    public function __construct($raw, array $levels, $level = 'all')
    {
        $this->raw = $raw;
        $this->levels = $levels;
        $this->level = $level;
    }

    /**
     * Parse the log.
     *
     * @return array
     */
    protected function parse()
    {
        $log = array();

        $pattern = "/\[\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}\].*/";

        preg_match_all($pattern, $this->raw, $headings);
        $data = preg_split($pattern, $this->raw);

        if ($data[0] < 1) {
            $trash = array_shift($data);
            unset($trash);
        }

        foreach ($headings as $heading) {
            for ($i = 0, $j = count($heading); $i < $j; $i++) {
                foreach ($this->levels as $level) {
                    if ($this->level == $level || $this->level == 'all') {
                        if (strpos(strtolower($heading[$i]), strtolower('.'.$level))) {
                            $log[] = array('level' => $level, 'header' => $heading[$i], 'stack' => $data[$i]);
                        }
                    }
                }
            }
        }

        unset($headings);
        unset($data);

        return array_reverse($log);
    }

    /**
     * Get the log data.
     *
     * @return array
     */
    public function data()
    {
        if (!$this->data) {
            $this->data = $this->parse();
        }

        return $this->data;
    }
}
