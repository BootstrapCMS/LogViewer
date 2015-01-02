<?php

/*
 * This file is part of Laravel LogViewer.
 *
 * (c) Graham Campbell <graham@mineuk.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

Route::get('logviewer', [
    'as'   => 'logviewer.index',
    'uses' => 'GrahamCampbell\LogViewer\Controllers\LogViewerController@getIndex',
]);

Route::get('logviewer/{sapi}/{date}/delete', [
    'as'   => 'logviewer.delete',
    'uses' => 'GrahamCampbell\LogViewer\Controllers\LogViewerController@getDelete',
]);

Route::get('logviewer/{sapi}/{date}/{level?}', [
    'as'   => 'logviewer.show',
    'uses' => 'GrahamCampbell\LogViewer\Controllers\LogViewerController@getShow',
]);

Route::get('logviewer/data/{sapi}/{date}/{level?}', [
    'as'   => 'logviewer.data',
    'uses' => 'GrahamCampbell\LogViewer\Controllers\LogViewerController@getData',
]);
