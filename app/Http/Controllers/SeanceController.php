<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Repositories\SeancesRepository;


class SeanceController extends SiteController
{
    public function __construct(SeancesRepository $sn_rep) {
    	parent::__construct(new \App\Repositories\NavbarsRepository(new \App\Navbar));
        $this->sn_rep = $sn_rep;
    }

    public function index () {
        $array = [];
        $seances = $this->sn_rep->get('*', FALSE, FALSE, ['date', 'asc']);
        $seances->load('performance', 'stage');
        $date = '';
        $j = 0; 
        foreach($seances as $seance) {
            if($date === $seance['date']) 
                $j++;
            else {
                $date = $seance['date'];
                $j=0;
            }
            $array[$seance['date']][$j]['id'] = $seance['id'];
            $array[$seance['date']][$j]['time'] = $seance['time'];
            $array[$seance['date']][$j]['performance_id'] = $seance['performance_id'];
            $array[$seance['date']][$j]['stage_id'] = $seance['stage_id'];
            $array[$seance['date']][$j]['performance'] = $seance['performance'];
            $array[$seance['date']][$j]['stage'] = $seance['stage'];
        }
        foreach($array as $a => $i) {
            $array['keys'][] = $a;
        }
    	return response()->json($array);
    }

    public function store() {

    }

    public function update() {

    }

    public function destroy() {
    	
    }
}
