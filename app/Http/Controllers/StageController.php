<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Repositories\StagesRepository;


class StageController extends SiteController
{
    public function __construct(StagesRepository $s_rep) {
    	parent::__construct(new \App\Repositories\NavbarsRepository(new \App\Navbar));
        $this->s_rep = $s_rep;
    }

    public function index () {
        $array = [];
        $stages = $this->s_rep->get();
        if(is_null($stages)) 
            return $this->error("stages");
        $stages->load('seances');
        for($i = 0; $i < count($stages); $i++) {
            $array[$i]['id'] = $stages[$i]['id'];
            $array[$i]['name'] = $stages[$i]['name'];
            if(empty($stages[$i]->seances[0]))
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
