<?php

/**
 * This file is part of Laravel LogViewer by Graham Campbell.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at http://bit.ly/UWsjkb.
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

Route::get('logviewer', array(
    'as' => 'logviewer.index',
    'uses' => 'GrahamCampbell\LogViewer\Http\Controllers\LogViewerController@getIndex',
));

Route::get('logviewer/{sapi}/{date}/delete', array(
    'as' => 'logviewer.delete',
    'uses' => 'GrahamCampbell\LogViewer\Http\Controllers\LogViewerController@getDelete',
));

Route::get('logviewer/{sapi}/{date}/{level?}', array(
    'as' => 'logviewer.show',
    'uses' => 'GrahamCampbell\LogViewer\Http\Controllers\LogViewerController@getShow',
));

Route::get('logviewer/data/{sapi}/{date}/{level?}', array(
    'as' => 'logviewer.data',
    'uses' => 'GrahamCampbell\LogViewer\Http\Controllers\LogViewerController@getData',
));
