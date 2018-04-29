<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Repositories\SeancesRepository;

use DB;
use App\Seance;
class SeanceController extends SiteController
{
    public function __construct(SeancesRepository $sn_rep) {
    	parent::__construct(new \App\Repositories\NavbarsRepository(new \App\Navbar));
        $this->sn_rep = $sn_rep;
    }
    public function checkBool($string) {
        $isFilter = $string === 'true' ? true : false;
        return $isFilter;
    }
    public function filter($seances) {
        $array = [];
        $date = '';
        $j = 0; 
    
        foreach($seances as $seance) {
            if($date === $seance['date']) 
                $j++;
            else {
                $date = $seance['date'];
                $j=0;
            }
            $array[$seance['date']][$j]['time'] = $seance['time'];
            $array[$seance['date']][$j]['date'] = $seance['date'];
            $array[$seance['date']][$j]['season_id'] = $seance['season_id'];
            $array[$seance['date']][$j]['performance_id'] = $seance['performance_id'];
            $array[$seance['date']][$j]['stage_id'] = $seance['stage_id'];
            $array[$seance['date']][$j]['performance'] = $seance['performance'];
            $array[$seance['date']][$j]['datetime'] = $seance['datetime'];
            $array[$seance['date']][$j]['stage'] = $seance['stage'];
        }
        foreach($array as $a => $i) {
            $array['keys'][] = $a;
        }

        return  $array;    
    }

    public function index (Request $request) {
        
        $filter = $request->input('filter');
        //$filter = $this->checkBool($isFilter); 
        if($filter === 'false') {
            $seances = $this->sn_rep->get('*', FALSE, FALSE, ['date', 'asc']);
            if(is_null($seances)) 
                return $this->error("seances");
            return response()->json($seances);
        }
        if($filter === 'true') {
            $seancesFilter = [];
            //$seances = $this->sn_rep->get('*', FALSE, [['date', '>=', date('Y-m-d'), ['time', '>', date('H:i:s')]]], ['date', 'asc']);
            $seances = Seance::whereIn('season_id', function($query) {
                $query->select(DB::raw(1))->from('seasons')->whereRaw('seasons.id = seances.season_id && seasons.isActive = 1');
            })->where('datetime', '>=', date('Y-m-d H:i:s'))->orderBy('date','asc')->with('performance', 'stage')
            ->get();
            if(is_null($seances)) 
                return $this->error("seances");
            $seancesFilter = $this->filter($seances);
            return response()->json($seancesFilter);
        }
    }

    public function store() {

    }

    public function update() {

    }

    public function destroy() {
    	
    }
}
