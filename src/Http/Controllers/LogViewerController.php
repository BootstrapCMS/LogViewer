<?php

/*
 * This file is part of Laravel LogViewer.
 *
 * (c) Graham Campbell <graham@alt-three.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GrahamCampbell\LogViewer\Http\Controllers;

use Carbon\Carbon;
use GrahamCampbell\LogViewer\Facades\LogViewer;
use Illuminate\Pagination\Paginator;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;

/**
 * This is the log viewer controller class.
 *
 * @author Graham Campbell <graham@alt-three.com>
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
     * @param int      $perPage
     * @param string[] $middleware
     *
     * @return void
     */
    public function __construct($perPage, array $middleware)
    {
        $this->perPage = $perPage;

        foreach ($middleware as $class) {
            $this->middleware($class);
        }
    }

    /**
     * Redirect to the show page.
     *
     * @return \Illuminate\Http\Response
     */
    public function getIndex()
    {
        $today = Carbon::today()->format('Y-m-d');

        if (Session::has('success') || Session::has('error')) {
            Session::reflash();
        }

        return Redirect::to('logviewer/'.$today.'/all');
    }

    /**
     * Delete the log.
     *
     * @param string $date
     *
     * @return \Illuminate\Http\Response
     */
    public function getDelete($date)
    {
        try {
            LogViewer::delete($date);
            $today = Carbon::today()->format('Y-m-d');

            return Redirect::to('logviewer/'.$today.'/all')
                ->with('success', 'Log deleted successfully!');
        } catch (\Exception $e) {
            return Redirect::to('logviewer/'.$date.'/all')
                ->with('error', 'There was an error while deleting the log.');
        }
    }

    /**
     * Show the log viewing page.
     *
     * @param string      $date
     * @param string|null $level
     *
     * @return \Illuminate\Http\Response
     */
    public function getShow($date, $level = null)
    {
        $logs = LogViewer::logs();

        if (!is_string($level)) {
            $level = 'all';
        }

        $page = Input::get('page');
        if (empty($page)) {
            $page = '1';
        }

        $data = [
            'logs'       => $logs,
            'date'       => $date,
            'url'        => 'logviewer',
            'data_url'   => URL::route('logviewer.index').'/data/'.$date.'/'.$level.'?page='.$page,
            'levels'     => LogViewer::levels(),
            'current'    => $level,
        ];

        return View::make('logviewer::show', $data);
    }

    /**
     * Show the log contents.
     *
     * @param string      $date
     * @param string|null $level
     *
     * @return \Illuminate\Http\Response
     */
    public function getData($date, $level = null)
    {
        if (!is_string($level)) {
            $level = 'all';
        }

        $data = LogViewer::data($date, $level);
        $paginator = new Paginator($data, $this->perPage);

        $path = (new \ReflectionClass($paginator))->getProperty('path');
        $path->setAccessible(true);
        $path->setValue($paginator, URL::route('logviewer.index').'/'.$date.'/'.$level);

        if (count($data) > $paginator->perPage()) {
            $log = array_slice($data, $paginator->firstItem() - 1, $paginator->perPage());
        } else {
            $log = $data;
        }

        return View::make('logviewer::data', compact('paginator', 'log'));
    }
}
