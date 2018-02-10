<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\EmployeesRepository;

class EmployeeController extends SiteController
{
    public function __construct(EmployeesRepository $e_rep) {
    	parent::__construct(new \App\Repositories\NavbarsRepository(new \App\Navbar));

    	$this->e_rep = $e_rep;
    }

    public function show($id) {
    	return response()->json($this->e_rep
    		->get('*', FALSE, ['position_id','=',$id]));
    }

    public function index() {
    	return response()->json($this->e_rep->get());
    }


}
