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

    public function index () {
        $seasons = $this->ss_rep->get();
        $seasons->load('performances');
        for($i = 0; $i < count($seasons); $i++) {
            $array[$i]['id'] = $seasons[$i]['id'];
            $array[$i]['name'] = $seasons[$i]['name'];
            $array[$i]['start_date'] = $seasons[$i]['start_date'];
            $array[$i]['end_date'] = $seasons[$i]['end_date'];
            if(empty($seasons[$i]->performances[0]))
                $array[$i]['is_parent'] = false;
            else {
                $array[$i]['is_parent'] = true;
            }
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
