<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Repositories\UnitsRepository;


class UnitController extends SiteController
{
    public function __construct(UnitsRepository $u_rep) {
    	parent::__construct(new \App\Repositories\NavbarsRepository(new \App\Navbar));
        $this->u_rep = $u_rep;
    }

    public function index (Request $request) {
        $units = $this->u_rep->get();
        $filter = $request->input('filter');
        if($filter==='false') {
            $units->load('employees');
            for($i = 0; $i < count($units); $i++) {
                $array[$i]['id'] = $units[$i]['id'];
                $array[$i]['name'] = $units[$i]['name'];
                if(empty($units[$i]->employees[0]))
                    $array[$i]['is_parent'] = false;
                else {
                    $array[$i]['is_parent'] = true;
                }
            }
            return response()->json($array);
        }
        if($filter==='performances') {
            $id = $request->input('id');
            if($id !== 0) {
                $units->load(['employees.performances' => function($query) use ($id) {
                    $query->whereRaw("performances.id = $id");
                }]);
                for($i = 0; $i < count($units); $i++) {
                    $array[$i]['id'] = $units[$i]['id'];
                    $array[$i]['name'] = $units[$i]['name'];
                    if(!empty($units[$i]->employees[0])) {
                        for($j = 0; $j < count($units[$i]->employees); $j++) {
                            if(empty($units[$i]->employees[$j]->performances[0]))
                                $array[$i]['is_parent'] = false;
                            else {
                                $array[$i]['is_parent'] = true;
                            }
                        }
                    } else {
                        $array[$i]['is_parent'] = false;
                    }
                }
                return response()->json($array);
                }
        }
       


    	
    }

    public function store() {

    }

    public function update() {

    }

    public function destroy() {
    	
    }
}
