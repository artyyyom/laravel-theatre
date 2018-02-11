<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NavbarController extends SiteController
{
    public function __construct() {
    	parent::__construct(new \App\Repositories\NavbarsRepository(new \App\Navbar));
    }

    public function index() {
    	return [
            response()->json($this->n_rep->get()),
            'status' => '200 OK'
        ];
    }

    public function store() {

    }

    public function update() {

    }

    public function destroy() {
    	
    }
}
