<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Repositories\NavbarsRepository;
class SiteController
{
	protected $n_rep;

    public function __construct(NavbarsRepository $n_rep) {
    	$this->n_rep = $n_rep;
    }
}
