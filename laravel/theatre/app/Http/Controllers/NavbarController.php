<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NavbarController extends SiteController
{
    public function __construct() {
    	parent::__construct(new \App\Repositories\NavbarsRepository(new \App\Navbar));
    }

    public function getNavbars() {
    	print_r($this->n_rep->get());

    }
}
