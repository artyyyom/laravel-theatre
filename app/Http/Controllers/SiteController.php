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
	protected $ss_rep; // seasons
	protected $sn_rep; // seances
	protected $u_rep;  // units
	protected $t_rep;  // tickets
	protected $cp_rep; // category_places
	protected $us_rep; // users

    public function __construct(NavbarsRepository $n_rep) {
    	$this->n_rep = $n_rep;

	}
	public function error($value) {
		return response()->json([
            'error' => "$value is empty"
        ], 404);
	}
	

}
