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
    	return response()->json($seasons);
    }

    public function store() {

    }

    public function update() {

    }

    public function destroy() {
    	
    }
}
