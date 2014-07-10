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

namespace GrahamCampbell\LogViewer\Controllers;

use Carbon\Carbon;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Paginator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use GrahamCampbell\LogViewer\Log;

/**
 * This is the log viewer controller class.
 *
 * @package    Laravel-LogViewer
 * @author     Graham Campbell
 * @copyright  Copyright 2014 Graham Campbell
 * @license    https://github.com/GrahamCampbell/Laravel-LogViewer/blob/master/LICENSE.md
 * @link       https://github.com/GrahamCampbell/Laravel-LogViewer
 */
class LogViewerController extends Controller
{
    /**
     * The number of entries per page.
     *
     * @var int
     */
    protected $perPage;

    /**
     * Create a new instance.
     *
     * @param  int    $perPage
     * @param  array  $filters
     * @return void
     */
    public function __construct($perPage, array $filters)
    {
        $this->perPage = $perPage;

        $this->beforeFilter('ajax', array('only' => array('getData')));

        foreach ($filters as $filter) {
            $this->beforeFilter($filter, array('only' => array('getIndex', 'getDelete', 'getShow', 'getData')));
        }
    }

    /**
     * Redirect to the show page.
     *
     * @return \Illuminate\Http\Response
     */
    public function getIndex()
    {
        $sapi = php_sapi_name();

        if (preg_match('/apache.*/', $sapi)) {
            $sapi = 'apache';
        }

        if (preg_match('/fpm.*/', $sapi)) {
            $sapi = 'fpm';
        }

        if (preg_match('/cgi.*/', $sapi)) {
            $sapi = 'cgi';
        }

        if (preg_match('/cli.*/', $sapi)) {
            $sapi = 'cli';
        }

        $today = Carbon::today()->format('Y-m-d');

        if (Session::has('success') || Session::has('error')) {
            Session::reflash();
        }

        return Redirect::to('logviewer/'.$sapi.'/'.$today.'/all');
    }

    /**
     * Delete the log.
     *
     * @return \Illuminate\Http\Response
     */
    public function getDelete($sapi, $date)
    {
        $log = new Log($sapi, $date);

        if ($log->delete()) {
            $today = Carbon::today()->format('Y-m-d');
            return Redirect::to('logviewer/'.$sapi.'/'.$today.'/all')
                ->with('success', 'Log deleted successfully!');
        } else {
            return Redirect::to('logviewer/'.$sapi.'/'.$date.'/all')
                ->with('error', 'There was an error while deleting the log.');
        }
    }

    /**
     * Show the log viewing page.
     *
     * @return \Illuminate\Http\Response
     */
    public function getShow($sapi, $date, $level = null)
    {
        $dir = storage_path('logs');

        $logs = array();

        $sapis = array(
            'apache' => 'Apache',
            'fpm' => 'Nginx',
            'cgi' => 'CGI',
            'srv' => 'HHVM',
            'cli' => 'CLI'
        );

        $empty = true;

        foreach ($sapis as $real => $human) {
            $logs[$real]['sapi'] = $human;

            $logs[$real]['logs'] = glob($dir.'/log-'.$real.'*', GLOB_BRACE);

            if (is_array($logs[$real]['logs'])) {
                $logs[$real]['logs'] = array_reverse($logs[$real]['logs']);
                foreach ($logs[$real]['logs'] as &$file) {
                    $empty = false;
                    $file = preg_replace('/.*(\d{4}-\d{2}-\d{2}).*/', '$1', basename($file));
                }
            } else {
                $logs[$real]['logs'] = array();
            }
        }

        if (is_null($level) || !is_string($level)) {
            $level = 'all';
        }

        $page = Input::get('page');
        if (is_null($page) || empty($page)) {
            $page = '1';
        }

        $data = array(
            'logs'       => $logs,
            'empty'      => $empty,
            'date'       => $date,
            'sapi_plain' => $sapi,
            'url'        => 'logviewer',
            'data_url'   => URL::route('logviewer.index').'/data/'.$sapi.'/'.$date.'/'.$level.'?page='.$page,
            'levels'     => (new Log($sapi, $date, $level))->getLevels(),
            'current'    => $level
        );

        return View::make('graham-campbell/logviewer::show', $data);
    }

    /**
     * Show the log contents.
     *
     * @return \Illuminate\Http\Response
     */
    public function getData($sapi, $date, $level = null)
    {
        if (is_null($level) || !is_string($level)) {
            $level = 'all';
        }

        $log = new Log($sapi, $date, $level);
        $data = $log->get();
        $page = Paginator::make($data, count($data), $this->perPage);
        $page->setBaseUrl(URL::route('logviewer.index').'/'.$sapi.'/'.$date.'/'.$level);

        $data = array(
            'paginator' => $page,
            'log'       => (count($data) > $page->getPerPage() ? array_slice($data, $page->getFrom()-1, $page->getPerPage()) : $data),
            'empty'     => $log->isEmpty()
        );

        return View::make('graham-campbell/logviewer::data', $data);
    }
}
