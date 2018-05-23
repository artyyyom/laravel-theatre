<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\PositionsRepository;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Position;
use DB;
use Illuminate\Support\Facades\Validator;

class PositionController extends SiteController
{
    public function __construct(PositionsRepository $p_rep) {
    	parent::__construct(new \App\Repositories\NavbarsRepository(new \App\Navbar));

    	$this->p_rep = $p_rep;
    }

    public function index() {
        $user = auth()->user();
        $array = [];
        $positions = $this->p_rep->get();
        if(is_null($positions)) 
            return $this->error("positions");
        $positions->load('employees');
        for($i = 0; $i < count($positions); $i++) {
            $array[$i]['id'] = $positions[$i]['id'];
            $array[$i]['name'] = $positions[$i]['name'];
            $array[$i]['order'] = $positions[$i]['order'];
            if(empty($positions[$i]->employees[0]))
                $array[$i]['is_parent'] = false;
            else {
                $array[$i]['is_parent'] = true;
            }
        }
        return response()->json($positions);
    }
    public function show($id) {
        $position = $this->p_rep->one($id);
        if(is_null($position)) 
            return $this->error("positions");
        return response()->json($position);
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
        $name = $request->name;
        try {
        $position = Position::create([
            'name' => $name,
            'order'=> $request->order 
        ]);
        return response()->json(['message' => 'Position successfully create'], 200);    
        }
        catch(Exception $e) {
            return response()->json(['message' => 'error position create'], 1451);
        }
    }
    public function update($id, Request $request) {
        $user = auth()->user();
        if(!$user)
            return response()->json(['error' => 'Unauthorized'], 401);
        if(!$user->hasRole(['moderator', 'administrator'])) 
            return response()->json(['error' => 'Unauthorized'], 403);
        try {
        $position = DB::table('positions')->where('id', $id)->update($request->all());
        
        if(!$position)
            return response()->json(['message' => 'Table not updated'], 404);

        return response()->json(['message' => 'Position update succesfully'], 200); 
        }
        catch(Exception $e) {
            return response()->json(['message' => 'error position update'], 1451);
        }
    }
    public function destroy($id) {
        $user = auth()->user();
        if(!$user)
            return response()->json(['error' => 'Unauthorized'], 401);
        if(!$user->hasRole(['moderator', 'administrator'])) 
            return response()->json(['error' => 'Unauthorized'], 403);
        try {
            $position = Position::find($id)->delete();
            return response()->json(['message' => 'Position succsessfully delete'], 200);
        }
        catch(Exception $e) {
            return response()->json(['message' => 'Position restrict delete'], 1451);
        }
    }
}


