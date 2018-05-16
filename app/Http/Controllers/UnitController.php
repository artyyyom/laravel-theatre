<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Unit;
use DB;
use App\Repositories\UnitsRepository;
use Illuminate\Support\Facades\Validator;

class UnitController extends SiteController
{
    public function __construct(UnitsRepository $u_rep) {
    	parent::__construct(new \App\Repositories\NavbarsRepository(new \App\Navbar));
        $this->u_rep = $u_rep;
    }

    public function index (Request $request) {
        $units = $this->u_rep->get();
        if(is_null($units)) 
            return $this->error("units");
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
    public function show($id) {
        $unit = $this->u_rep->one($id);
        if(is_null($unit)) 
            return $this->error("units");
        return response()->json($unit);
    }
    public function store(Request $request) {  
        $user = auth()->user();
        if(!$user)
            return response()->json(['error' => 'Unauthorized'], 401);
        if(!$user->hasRole(['moderator', 'administrator'])) 
            return response()->json(['error' => 'Unauthorized'], 403);

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'order' => 'required',
        ]);
        if($validator->fails()) {
            return response()->json($validator->errors());
        }
        $name = mb_strtolower($request->name);
        try {
        $unit = Unit::create([
            'name' => $name,
            'order'=> $request->order 
        ]);
        return response()->json(['message' => 'Unit successfully update'], 200);    
        }
        catch(Exception $e) {
            return response()->json(['message' => 'error unit create'], 1451);
        }
    }

    public function update($id, Request $request) {
        $user = auth()->user();
        if(!$user)
            return response()->json(['error' => 'Unauthorized'], 401);
        if(!$user->hasRole(['moderator', 'administrator'])) 
            return response()->json(['error' => 'Unauthorized'], 403);
        try {
        $unit = DB::table('units')->where('id', $id)->update($request->all());
        
        if(!$unit)
            return response()->json(['message' => 'Table not updated'], 404);

        return response()->json(['message' => 'Unit update succesfully'], 200); 
        }
        catch(Exception $e) {
            return response()->json(['message' => 'error unit update'], 1451);
        }
    }

    public function destroy($id) {
        $user = auth()->user();
        if(!$user)
            return response()->json(['error' => 'Unauthorized'], 401);
        if(!$user->hasRole(['moderator', 'administrator'])) 
            return response()->json(['error' => 'Unauthorized'], 403);
        try {
            $unit = Unit::find($id)->delete();
            return response()->json(['message' => 'Unit succsessfully delete'], 200);
        }
        catch(Exception $e) {
            return response()->json(['message' => 'Unit restrict delete'], 1451);
        }
        

    }
}
