<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Repositories\SeasonsRepository;
use Illuminate\Support\Facades\Validator;
use DB;
use App\Season;

class SeasonController extends SiteController
{
    public function __construct(SeasonsRepository $ss_rep) {
    	parent::__construct(new \App\Repositories\NavbarsRepository(new \App\Navbar));
        $this->ss_rep = $ss_rep;
    }
    public function isParent($seasons) {
        $array = [];
        for($i = 0; $i < count($seasons); $i++) {
            $array[$i]['id'] = $seasons[$i]['id'];
            $array[$i]['name'] = $seasons[$i]['name'];
            $array[$i]['start_date'] = $seasons[$i]['start_date'];
            $array[$i]['end_date'] = $seasons[$i]['end_date'];
            $array[$i]['isActive'] = $seasons[$i]['isActive'];
            if(empty($seasons[$i]->seances[0]))
                $array[$i]['is_parent'] = false;
            else {
                $array[$i]['is_parent'] = true;
            }
        }
        return $array;
    }
    public function index (Request $request) {
        $seasonsFilter = [];
        $filter = $request->input('filter');
        /* Get all seasons */
        if($filter === 'false') {
            $seasons = $this->ss_rep->get('*', FALSE, FALSE, ['start_date', 'desc']);
            if(is_null($seasons)) 
                return $this->error("seasons");
            $seasons->load('seances');
            $seasonsFilter = $this->isParent($seasons);
            return response()->json($seasonsFilter);
        }
        /* Get active season */
        if($filter === 'last') {
            $seasons = $this->ss_rep->get('*', 1, [['isActive','=',1]], ['start_date', 'desc']);
            if(is_null($seasons)) 
                return $this->error("seasons");
            // $seasons->load('seances');
            $seasonsFilter = $this->isParent($seasons);
            return response()->json($seasonsFilter);
        }
    }

    public function show($id) {
        $season = $this->ss_rep->one($id);
        if(is_null($season)) 
            return $this->error("season");
        return response()->json($season);
    }

    public function store(Request $request) {
        $user = auth()->user();
        if(!$user)
            return response()->json(['error' => 'Unauthorized'], 401);
        if(!$user->hasRole(['moderator', 'administrator'])) 
            return response()->json(['error' => 'Unauthorized'], 403);

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'isActive' => 'required'
        ]);
        if($validator->fails()) {
            return response()->json($validator->errors());
        }
        $name = $request->name;
        try {
        $season = Season::create([
            'name' => $name, 
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'isActive' => $request->isActive
        ]);
        return response()->json(['message' => 'Season successfully create'], 200);    
        }
        catch(Exception $e) {
            return response()->json(['message' => 'error season create'], 1451);
        }
    }

    public function update($id, Request $request) {
        $user = auth()->user();
        if(!$user)
            return response()->json(['error' => 'Unauthorized'], 401);
        if(!$user->hasRole(['moderator', 'administrator'])) 
            return response()->json(['error' => 'Unauthorized'], 403);
        try {
        $season = DB::table('seasons')->where('id', $id)->update($request->all());
        
        if(!$season)
            return response()->json(['message' => 'Table not updated'], 404);

        return response()->json(['message' => 'Season update succesfully'], 200); 
        }
        catch(Exception $e) {
            return response()->json(['message' => 'error season update'], 1451);
        }
    }

    public function destroy($id) {
    	$user = auth()->user();
        if(!$user)
            return response()->json(['error' => 'Unauthorized'], 401);
        if(!$user->hasRole(['moderator', 'administrator'])) 
            return response()->json(['error' => 'Unauthorized'], 403);
        try {
            $season = Season::find($id)->delete();
            return response()->json(['message' => 'Season succsessfully delete'], 200);
        }
        catch(Exception $e) {
            return response()->json(['message' => 'Season restrict delete'], 1451);
        }
    }
}
