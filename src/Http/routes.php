<?php

/*
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

$router->get('logviewer', ['as' => 'logviewer.index', 'uses' => 'LogViewerController@getIndex']);

$router->get('logviewer/{date}/delete', ['as' => 'logviewer.delete', 'uses' => 'LogViewerController@getDelete']);

$router->get('logviewer/{date}/{level?}', ['as' => 'logviewer.show', 'uses' => 'LogViewerController@getShow']);

$router->get('logviewer/data/{date}/{level?}', ['as' => 'logviewer.data', 'uses' => 'LogViewerController@getData']);
