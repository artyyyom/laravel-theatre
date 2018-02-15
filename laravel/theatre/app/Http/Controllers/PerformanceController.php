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
		$performances = $this->pm_rep->get()
							 ->load('employees','seances.stage.rows_places');
		//dd($performances);

    	if(is_null($performances)) 
    		return response()->json($this->error);
		dd($performances);
    	return response()->json($performances);
    }
    
    public function show($id) {
    	$performance = $this->pm_rep->get(
    									['name','genre','photo_main'],
    									FALSE, 
    									['id','=',$id]);
    	if(is_null($performance)) 
    		return response()->json($this->error);
    	
    	$performance->load('employees','seances.stage');
    	return response()->json($performance);
    }
}
