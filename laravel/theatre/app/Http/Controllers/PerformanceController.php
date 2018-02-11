<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\PerformancesRepository;
use DB;
class PerformanceController extends SiteController
{
    public function __construct(PerformancesRepository $pm_rep) {
    	parent::__construct(new \App\Repositories\NavbarsRepository(new \App\Navbar));

    	$this->pm_rep = $pm_rep;
    }

    public function index() {
		$performances = $this->pm_rep->get()->load('employees','seances.stage');
    	dd($performances[0]);

    	return $performances;
    }
    public function show($id) {
    	$performance = $this->pm_rep->get(['name','genre','photo_main'],FALSE, ['id','=',$id])->load('seances.stage');
    	dd($performance);
    	return $performance;
    }
}
