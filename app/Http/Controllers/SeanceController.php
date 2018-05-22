<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Repositories\SeancesRepository;
use Illuminate\Support\Facades\Validator;
use DB;
use App\Seance;
use App\Ticket;
use App\User;
class SeanceController extends SiteController
{
    public function __construct(SeancesRepository $sn_rep) {
    	parent::__construct(new \App\Repositories\NavbarsRepository(new \App\Navbar));
        $this->sn_rep = $sn_rep;
    }
    public function checkBool($string) {
        $isFilter = $string === 'true' ? true : false;
        return $isFilter;
    }
    public function filter($seances) {
        $array = [];
        $date = '';
        $j = 0; 
    
        foreach($seances as $seance) {
            if($date === $seance['date']) 
                $j++;
            else {
                $date = $seance['date'];
                $j=0;
            }
            $array[$seance['date']][$j]['id'] = $seance['id'];
            $array[$seance['date']][$j]['time'] = $seance['time'];
            $array[$seance['date']][$j]['date'] = $seance['date'];
            $array[$seance['date']][$j]['season_id'] = $seance['season_id'];
            $array[$seance['date']][$j]['performance_id'] = $seance['performance_id'];
            $array[$seance['date']][$j]['stage_id'] = $seance['stage_id'];
            $array[$seance['date']][$j]['performance'] = $seance['performance'];
            $array[$seance['date']][$j]['datetime'] = $seance['datetime'];
            $array[$seance['date']][$j]['stage'] = $seance['stage'];
        }
        foreach($array as $a => $i) {
            $array['keys'][] = $a;
        }

        return  $array;    
    }

    public function index (Request $request) {
        
        $filter = $request->input('filter');
        //$filter = $this->checkBool($isFilter); 
        /* Get all seances */
        if($filter === 'false') {
            $seances = $this->sn_rep->get('*', FALSE, FALSE, ['date', 'asc']);
            if(is_null($seances)) 
                return $this->error("seances");
            $seances->load('performance');
            return response()->json($seances);
        }
        /* Get actual seances */
        if($filter === 'true') {
            $seancesFilter = [];
            //$seances = $this->sn_rep->get('*', FALSE, [['date', '>=', date('Y-m-d'), ['time', '>', date('H:i:s')]]], ['date', 'asc']);
            $seances = Seance::whereIn('season_id', function($query) {
                $query->select(DB::raw(1))->from('seasons')->whereRaw('seasons.id = seances.season_id && seasons.isActive = 1');
            })->where('datetime', '>=', date('Y-m-d H:i:s'))->orderBy('date','asc')->orderBy('time', 'asc')->with('performance', 'stage')
            ->get();
            if(is_null($seances)) 
                return $this->error("seances");
            $seancesFilter = $this->filter($seances);
            return response()->json($seancesFilter);
        }

    }
    public function show($id) {
        $seance = $this->sn_rep->one($id);
        if(is_null($seance)) 
            return $this->error("seance");
        $seance->load('performance', 'stage', 'season');
        return response()->json($seance);
    }

    public function store(Request $request) {
        $user = auth()->user();
        if(!$user)
            return response()->json(['error' => 'Unauthorized'], 401);
        if(!$user->hasRole(['moderator', 'administrator'])) 
            return response()->json(['error' => 'Unauthorized'], 403);

        $validator = Validator::make($request->all(), [
            'date' => 'required|date',
            'time' => 'required',
            'datetime' => 'required',
            'performance_id' => 'required',
            'stage_id' => 'required',
            'season_id' => 'required'
        ]);
        if($validator->fails()) {
            return response()->json($validator->errors());
        }
        try {
        $seance = Seance::create([
           'date' => $request->date,
           'time' => $request->time, 
           'datetime' => $request->datetime,
           'performance_id' => $request->performance_id,
           'stage_id' => $request->stage_id,
           'season_id' => $request->season_id
        ]);
        
        return response()->json($seance['id'], 200);    
        }
        catch(Exception $e) {
            return response()->json(['message' => 'error seance create'], 1451);
        }
        
    }

    public function update($id, Request $request) {
        $user = auth()->user();
        if(!$user)
            return response()->json(['error' => 'Unauthorized'], 401);
        if(!$user->hasRole(['moderator', 'administrator'])) 
            return response()->json(['error' => 'Unauthorized'], 403);
        try {
            $seance = DB::table('seances')->where('id', $id)->update($request->all());
            
        if(!$seance)
            return response()->json(['message' => 'Table not updated'], 404);

        return response()->json(['message' => 'Seance update succesfully'], 200); 
        }
        catch(Exception $e) {
            return response()->json(['message' => 'error seance update'], 1451);
        }
    }

    public function destroy($id) {
        $user = auth()->user();
        if(!$user)
            return response()->json(['error' => 'Unauthorized'], 401);
        if(!$user->hasRole(['moderator', 'administrator'])) 
            return response()->json(['error' => 'Unauthorized'], 403);
        try {
            $performance = Seance::find($id)->delete();
            return response()->json(['message' => 'Seance succsessfully delete'], 200);
        }
        catch(Exception $e) {
            return response()->json(['message' => 'Performance restrict delete'], 1451);
        }
    }
    public function getActualSeances($id) {
        $seances = Seance::whereIn('id', function($query) use ($id) {
            $query->select('seance_id')->from('tickets')->whereRaw("seances.id = tickets.seance_id && tickets.user_id = $id");
        })->where('datetime', '>=', date('Y-m-d H:i:s'))->orderBy('datetime','asc')
          ->with(['tickets' => function($query) use ($id) {
            $query->where("user_id", $id)->with('category_place');
        }])->with('performance', 'stage')->get();
        return $seances;
    }
    public function getUserActualSeances(Request $request) {
        $user = auth()->user();
        if($user && $user->hasRole(['user'])) {
            $seances = $this->getActualSeances($user->id);
            return response()->json($seances);
        } 
        if($user && $user->hasRole(['moderator', 'administrator'])) {
            $user = User::find($request->id);
            $seances = $this->getActualSeances($user->id);
            return response()->json($seances);
        }
        else {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }
    public function getHistorySeances($id) {
        $seances = Seance::whereIn('id', function($query) use ($id) {
            $query->select('seance_id')->from('tickets')->whereRaw("seances.id = tickets.seance_id && tickets.user_id = $id");
        })->where('datetime', '<', date('Y-m-d H:i:s'))->orderBy('datetime','desc')
          ->with(['tickets.category_place' => function($query) use ($id) {
            $query->where("tickets.user_id", $id)->with('category_place');
        }])->with('performance', 'stage')->get();
        return $seances;
    }
    public function getUserHistorySeances(Request $request) {
        $user = auth()->user();
        if($user && $user->hasRole(['user'])) {
            $seances = $this->getHistorySeances($user->id);
            return response()->json($seances); 
        } 
        if($user && $user->hasRole(['moderator', 'administrator'])) {
            $user = User::find($request->id);
            $seances = $this->getHistorySeances($user->id);
            return response()->json($seances);
        }
        else {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }
}
