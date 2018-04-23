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
		$performances = $this->pm_rep->get();
		$performances->load('season', 'seances.stage');
    	if(is_null($performances)) 
    		return response()->json($this->error);
	
    	return response()->json($performances);
    }
    
    public function getOne($id) {
    	$performance = $this->pm_rep->get(
    									['*'],
    									FALSE, 
    									['id','=',$id]);
    	if(is_null($performance)) 
    		return response()->json($this->error);
    	
    	$performance->load('employees','seances.stage');
    	return response()->json(['data' => $performance, 'status' => '200 OK']);
    }
}
