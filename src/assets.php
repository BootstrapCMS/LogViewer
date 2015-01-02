<?php

/*
 * This file is part of Laravel LogViewer.
 *
 * (c) Graham Campbell <graham@mineuk.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Lightgear\Asset\Facades\Asset;

Asset::registerStyles([
    'graham-campbell/logviewer/src/assets/css/logviewer.css',
], '', 'logviewer');

Asset::registerScripts([
    'graham-campbell/logviewer/src/assets/js/logviewer.js',
], '', 'logviewer');
