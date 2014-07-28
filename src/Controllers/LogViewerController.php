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
use GrahamCampbell\LogViewer\Facades\LogViewer;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Paginator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;

/**
 * This is the log viewer controller class.
 *
 * @author    Graham Campbell <graham@mineuk.com>
 * @copyright 2014 Graham Campbell
 * @license   <https://github.com/GrahamCampbell/Laravel-LogViewer/blob/master/LICENSE.md> Apache 2.0
 */
class LogViewerController extends Controller
{
    /**
     * The number of entries per page.
     *
     * @type int
     */
    protected $perPage;

    /**
     * Create a new instance.
     *
     * @param int      $perPage
     * @param string[] $filters
     *
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
        $sapi = LogViewer::sapi();

        $today = Carbon::today()->format('Y-m-d');

        if (Session::has('success') || Session::has('error')) {
            Session::reflash();
        }

        return Redirect::to('logviewer/'.$sapi.'/'.$today.'/all');
    }

    /**
     * Delete the log.
     *
     * @param string $sapi
     * @param string $date
     *
     * @return \Illuminate\Http\Response
     */
    public function getDelete($sapi, $date)
    {
        try {
            LogViewer::delete($sapi, $date);
            $today = Carbon::today()->format('Y-m-d');
            return Redirect::to('logviewer/'.$sapi.'/'.$today.'/all')
                ->with('success', 'Log deleted successfully!');
        } catch (\Exception $e) {
            return Redirect::to('logviewer/'.$sapi.'/'.$date.'/all')
                ->with('error', 'There was an error while deleting the log.');
        }
    }

    /**
     * Show the log viewing page.
     *
     * @param string $sapi
     * @param string $date
     * @param string $level
     *
     * @return \Illuminate\Http\Response
     */
    public function getShow($sapi, $date, $level = null)
    {
        $logs = LogViewer::logs();

        if (!is_string($level)) {
            $level = 'all';
        }

        $page = Input::get('page');
        if (empty($page)) {
            $page = '1';
        }

        $data = array(
            'logs'       => $logs,
            'date'       => $date,
            'sapi_plain' => $sapi,
            'url'        => 'logviewer',
            'data_url'   => URL::route('logviewer.index').'/data/'.$sapi.'/'.$date.'/'.$level.'?page='.$page,
            'levels'     => LogViewer::levels(),
            'current'    => $level
        );

        return View::make('graham-campbell/logviewer::show', $data);
    }

    /**
     * Show the log contents.
     *
     * @param string $sapi
     * @param string $date
     * @param string $level
     *
     * @return \Illuminate\Http\Response
     */
    public function getData($sapi, $date, $level = null)
    {
        if (!is_string($level)) {
            $level = 'all';
        }

        $data = LogViewer::data($sapi, $date, $level);
        $page = Paginator::make($data, count($data), $this->perPage);
        $page->setBaseUrl(URL::route('logviewer.index').'/'.$sapi.'/'.$date.'/'.$level);

        if (count($data) > $page->getPerPage()) {
            $data = array_slice($data, $page->getFrom() - 1, $page->getPerPage());
        }

        return View::make('graham-campbell/logviewer::data', array('paginator' => $page, 'log'  => $data));
    }
}
