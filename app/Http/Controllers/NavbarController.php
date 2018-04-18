<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NavbarController extends SiteController
{
    public function __construct() {
    	parent::__construct(new \App\Repositories\NavbarsRepository(new \App\Navbar));
    }

    public function getAll () {
        $navbars = $this->n_rep->get();
        if(is_null($navbars)) 
            return response()->json($this->error);

    	return response()->json(["data" => $navbars, "status" => "200"]);
    }

    public function store() {

    }

    public function update() {

    }

    public function destroy() {
    	
    }
}
