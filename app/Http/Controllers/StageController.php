<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Repositories\StagesRepository;
use App\Stage;
use Illuminate\Support\Facades\Validator;
use DB;

class StageController extends SiteController
{
    public function __construct(StagesRepository $s_rep) {
    	parent::__construct(new \App\Repositories\NavbarsRepository(new \App\Navbar));
        $this->s_rep = $s_rep;
    }

    public function index () {
        $array = [];
        $stages = $this->s_rep->get();
        if(is_null($stages)) 
            return $this->error("stages");
        $stages->load('seances');
        for($i = 0; $i < count($stages); $i++) {
            $array[$i]['id'] = $stages[$i]['id'];
            $array[$i]['name'] = $stages[$i]['name'];
            if(empty($stages[$i]->seances[0]))
                $array[$i]['is_parent'] = false;
            else {
                $array[$i]['is_parent'] = true;
            }
        }

    	return response()->json($array);
    }
    public function show($id) {
        $stage = $this->s_rep->one($id);
        if(is_null($stage)) 
            return $this->error("stage");
        return response()->json($stage);
    }

    public function store(Request $request) {
        $user = auth()->user();
        if(!$user)
            return response()->json(['error' => 'Unauthorized'], 401);
        if(!$user->hasRole(['moderator', 'administrator'])) 
            return response()->json(['error' => 'Unauthorized'], 403);

        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);
        if($validator->fails()) {
            return response()->json($validator->errors());
        }
        $name = $request->name;
        
        try {
        $stage = Stage::create([
            'name' => $name
        ]);
        return response()->json(['message' => 'Stage successfully create'], 200);    
        }
        catch(Exception $e) {
            return response()->json(['message' => 'error stage create'], 1451);
        }
    }

    public function update($id, Request $request) {
        $user = auth()->user();
        if(!$user)
            return response()->json(['error' => 'Unauthorized'], 401);
        if(!$user->hasRole(['moderator', 'administrator'])) 
            return response()->json(['error' => 'Unauthorized'], 403);
        try {
        $stage = DB::table('stages')->where('id', $id)->update($request->all());
        
        if(!$stage)
            return response()->json(['message' => 'Table not update'], 404);

        return response()->json(['message' => 'Stage update succesfully'], 200); 
        }
        catch(Exception $e) {
            return response()->json(['message' => 'error unit update'], 1451);
        }
    }

    public function destroy() {
        $user = auth()->user();
        if(!$user)
            return response()->json(['error' => 'Unauthorized'], 401);
        if(!$user->hasRole(['moderator', 'administrator'])) 
            return response()->json(['error' => 'Unauthorized'], 403);
        try {
            $stage = Stage::find($id)->delete();
            return response()->json(['message' => 'Stage succsessfully delete'], 200);
        }
        catch(Exception $e) {
            return response()->json(['message' => 'Stage restrict delete'], 1451);
        }

    }
}
