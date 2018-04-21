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

    public function getOneProfession($id) {
        $employee = $this->e_rep
            ->get('*', FALSE, ['position_id','=',$id]);

        if(is_null($employee)) 
            return response()->json($this->error);

    	return response()->json(['data' => $employee, 'status' => '200']);
    }

    public function index() {
        $employees = $this->e_rep->get();
        return response()->json($employees);
    }
    public function store() { }

    public function update($id) { }

    public function destroy($id) { }

    public function show($id) {
        $employee = $this->e_rep->one($id);

        if(is_null($employee)) 
            return response()->json($this->error);

       return response()->json(['data' => $employee, 'status' => '200']);
    }
 

}
