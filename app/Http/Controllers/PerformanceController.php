<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\PerformancesRepository;
use DB;
use App\Performance;
use \App\Seance;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PerformanceController extends SiteController
{
    public function __construct(PerformancesRepository $pm_rep) {
    	parent::__construct(new \App\Repositories\NavbarsRepository(new \App\Navbar));
        
    	$this->pm_rep = $pm_rep;
    }
    public function upload(Request $request) {
        Storage::put('avatars/1', $fileContents);

    }
    public function index() {
		$performances = $this->pm_rep->get();
		$performances->load('seances.stage');
    	if(is_null($performances)) 
            return $this->error("performances");
	
    	return response()->json($performances);
    }
    
    public function show($id, Request $request) {
        $filter = $request->input('filter');
        if($filter === 'false') {
            $performance = $this->pm_rep->one($id);
            if(is_null($performance)) 
                return $this->error("performance");
            $performance->load('employees.unit');
        //    $employee->pivot->role;
            return response()->json($performance);
        }
        /* Get certain seances */
        if($filter === 'seances') {
            $seance_id = $request->input('seance_id');
            $seance = Seance::where('id', '=', $seance_id)->first();
            $date =  $seance['date'];
            $performance = $this->pm_rep->one($id);
            if(is_null($performance)) 
                return $this->error("performance");
            if($date === date('Y-m-d')) {
                $performance->load(['seances' => function($query) use ($date) {
                    $query->where('seances.date', '=', $date)
                          ->where('seances.time', '>', date('H:i:s'))->with('stage');
                }]);

                return response()->json($performance);

            }
            if($date !== date('Y-m-d')) {
                
                $performance->load(['seances' => function($query) use ($date) {
                    $query->where('date', '=', $date)->with('stage');
                }]);
                return response()->json($performance);
            }
        }
    }
    public function store(Request $request) {
        $user = auth()->user();
        if(!$user)
            return response()->json(['error' => 'Unauthorized'], 401);
        if(!$user->hasRole(['moderator', 'administrator'])) 
            return response()->json(['error' => 'Unauthorized'], 403);
        $validator = Validator::make($request->all(), [
                'name' => 'required',
                'genre' => 'required',
                'duration' => 'required',
                'description' => 'required',
                'author' => 'required',
                'age_restrict' => 'required',
        ]);
        
        if($validator->fails()) {
            return response()->json($validator->errors());
        }
    
        try {
        $performance = Performance::create([
            'name' => $request->name,
            'genre' => $request->genre,
            'duration'=> $request->duration, 
            'description' => $request->description,
            'photo_main' => $request->photo_main,
            'photos' => $request->photos,
            'author' => $request->author,
            'age_restrict' => $request->age_restrict,
        ]);
        foreach($request->employees as $employee) {
            $performance->employees()->attach($employee['id'], ['role' => $employee['name']]);
        }
        return response()->json(['message' => 'Performance successfully create'], 200);    
        }
        catch(Exception $e) {
            return response()->json(['message' => 'error performance create'], 1451);
        }
    }
    public function update($id, Request $request) {

        $user = auth()->user();
        if(!$user)
            return response()->json(['error' => 'Unauthorized'], 401);
        if(!$user->hasRole(['moderator', 'administrator'])) 
            return response()->json(['error' => 'Unauthorized'], 403);

        try {
            $performance = Performance::find($id);
            $performanceUpdate = DB::table('performances')->where('id', $id)
                    ->update([
                        'name' => $request->name,
                        'genre' => $request->genre,
                        'duration'=> $request->duration, 
                        'description' => $request->description,
                        'photo_main' => $request->photo_main,
                        'photos' => $request->photos,
                        'author' => $request->author,
                        'age_restrict' => $request->age_restrict,            
                    ]);
            DB::table('performances_employees')->where('performance_id', $id)->delete();                
            foreach($request->employees as $employee) {
                $performance->employees()->attach($employee['id'], ['role' => $employee['name']]);
            }
    
            return response()->json(['message' => 'Performance update succesfully'], 200); 
            }
            catch(Exception $e) {
                return response()->json(['message' => 'error performance update'], 1451);
            }
    }
    public function destroy($id) {
        $user = auth()->user();
        if(!$user)
            return response()->json(['error' => 'Unauthorized'], 401);
        if(!$user->hasRole(['moderator', 'administrator'])) 
            return response()->json(['error' => 'Unauthorized'], 403);
        try {
            $performance = Performance::find($id)->delete();
            return response()->json(['message' => 'Performance succsessfully delete'], 200);
        }
        catch(Exception $e) {
            return response()->json(['message' => 'Performance restrict delete'], 1451);
        }
    }
    public function uploadPerformancePhotos(Request $request) {
        $user = auth()->user();
        if(!$user)
            return response()->json(['error' => 'Unauthorized'], 401);
        if(!$user->hasRole(['moderator', 'administrator'])) 
            return response()->json(['error' => 'Unauthorized'], 403);
        if ($request->hasFile('photo')) {
          $filename = $request->photo->getClientOriginalName();
          $request->photo->move(base_path('public/images/performances'), $filename);
          return response()->json(['message' => 'Photo successfully upload'], 200);
        }
        if ($request->hasFile('photos')) {
            foreach($request->photos as $photo) {
                $filename = $photo->getClientOriginalName();
                $photo->move(base_path('public/images/performances'), $filename);   
            }
            return response()->json(['message' => 'Photos successfully upload'], 200);
        }
    }
}
