<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\PositionsRepository;

class PositionController extends SiteController
{
    public function __construct(PositionsRepository $p_rep) {
    	parent::__construct(new \App\Repositories\NavbarsRepository(new \App\Navbar));

    	$this->p_rep = $p_rep;
    }

    public function index() {
        $array = [];
        $positions = $this->p_rep->get();
        if(is_null($positions)) 
            return $this->error("positions");
        $positions->load('employees');
        for($i = 0; $i < count($positions); $i++) {
            $array[$i]['id'] = $positions[$i]['id'];
            $array[$i]['name'] = $positions[$i]['name'];
            $array[$i]['order'] = $positions[$i]['order'];
            if(empty($positions[$i]->employees[0]))
                $array[$i]['is_parent'] = false;
            else {
                $array[$i]['is_parent'] = true;
            }
        }
        return response()->json($positions);
    }
}
