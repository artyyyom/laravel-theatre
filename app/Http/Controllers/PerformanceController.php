<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\PerformancesRepository;
use DB;
use \App\Seance;
class PerformanceController extends SiteController
{
    public function __construct(PerformancesRepository $pm_rep) {
    	parent::__construct(new \App\Repositories\NavbarsRepository(new \App\Navbar));

    	$this->pm_rep = $pm_rep;
    }

    public function index() {
		$performances = $this->pm_rep->get();
		$performances->load('seances.stage');
    	if(is_null($performances)) 
            return $this->error("performances");
	
    	return response()->json($performances);
    }
    
    public function show($id, Request $request) {
        $filter = $request->input('filter');
        if($filter === 'false') {
            $performance = $this->pm_rep->one($id);
            if(is_null($performance)) 
                return $this->error("performance");
            $performance->load('employees.unit');
        //    $employee->pivot->role;
            return response()->json($performance);
        }
        /* Get certain seances */
        if($filter === 'seances') {
            $seance_id = $request->input('seance_id');
            $seance = Seance::where('id', '=', $seance_id)->first();
            $date =  $seance['date'];
            $performance = $this->pm_rep->one($id);
            if(is_null($performance)) 
                return $this->error("performance");
            if($date === date('Y-m-d')) {
                $performance->load(['seances' => function($query) use ($date) {
                    $query->where('seances.date', '=', $date)
                          ->where('seances.time', '>', date('H:i:s'))->with('stage');
                }]);

                return response()->json($performance);

            }
            if($date !== date('Y-m-d')) {
                
                $performance->load(['seances' => function($query) use ($date) {
                    $query->where('date', '=', $date)->with('stage');
                }]);
                return response()->json($performance);
            }
        }
    }
}
