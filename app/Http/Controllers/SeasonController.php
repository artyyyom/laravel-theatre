<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Repositories\SeasonsRepository;


class SeasonController extends SiteController
{
    public function __construct(SeasonsRepository $ss_rep) {
    	parent::__construct(new \App\Repositories\NavbarsRepository(new \App\Navbar));
        $this->ss_rep = $ss_rep;
    }
    public function isParent($seasons) {
        $array = [];
        for($i = 0; $i < count($seasons); $i++) {
            $array[$i]['id'] = $seasons[$i]['id'];
            $array[$i]['name'] = $seasons[$i]['name'];
            $array[$i]['start_date'] = $seasons[$i]['start_date'];
            $array[$i]['end_date'] = $seasons[$i]['end_date'];
            $array[$i]['isActive'] = $seasons[$i]['isActive'];
            if(empty($seasons[$i]->seances[0]))
                $array[$i]['is_parent'] = false;
            else {
                $array[$i]['is_parent'] = true;
            }
        }
        return $array;
    }
    public function index (Request $request) {
        $seasonsFilter = [];
        $filter = $request->input('filter');
        if($filter === 'false') {
            $seasons = $this->ss_rep->get('*', FALSE, FALSE, ['start_date', 'desc']);
            $seasons->load('seances');
            $seasonsFilter = $this->isParent($seasons);
            return response()->json($seasonsFilter);
        }
        if($filter === 'last') {
            $seasons = $this->ss_rep->get('*', 1, [['isActive','=',1]], ['start_date', 'desc']);
           // $seasons->load('seances');
            $seasonsFilter = $this->isParent($seasons);
            return response()->json($seasonsFilter);
        }
    }

    public function store() {

    }

    public function update() {

    }

    public function destroy() {
    	
    }
}
