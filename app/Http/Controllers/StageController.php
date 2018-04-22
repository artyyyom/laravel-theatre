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
        $stages = $this->s_rep->get();
    	return response()->json($stages);
    }

    public function store() {

    }

    public function update() {

    }

    public function destroy() {
    	
    }
}
