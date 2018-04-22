<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Repositories\NavbarsRepository;


class SiteController
{
	protected $error = '{"status": "505 Internal Server Error"}';

	protected $n_rep;  // navigations
	protected $p_rep;  // positions
	protected $e_rep;  // employees
	protected $pm_rep; // performances
	protected $rp_rep; // rows_places
	protected $s_rep;  // stages

    public function __construct(NavbarsRepository $n_rep) {
    	$this->n_rep = $n_rep;

    }


}
