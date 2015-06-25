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
 * This is the log class.
 *
 * @author Graham Campbell <graham@alt-three.com>
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
        $log = [];

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
                            $log[] = ['level' => $level, 'header' => $heading[$i], 'stack' => $data[$i]];
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
