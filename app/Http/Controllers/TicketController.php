<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\TicketsRepository;
use Illuminate\Support\Facades\Validator;
use App\Ticket;
use DB;


class TicketController extends SiteController
{
    public function __construct(TicketsRepository $t_rep) {
    	parent::__construct(new \App\Repositories\NavbarsRepository(new \App\Navbar));

    	$this->t_rep = $t_rep;
    }

    public function index(Request $request) {
        $filter = $request->input('filter');
        if($filter === 'false') {
            $tickets = $this->t_rep->get();
            if(is_null($tickets)) 
                return $this->error("tickets");
            $tickets->load('category_place');
            return response()->json($tickets);
    
        }
        if($filter === 'seances') {
            $seance_id = $request->input('seance_id');
            $tickets = $this->t_rep->get('*', FALSE, [['seance_id', '=', $seance_id]]);
            if(is_null($tickets)) 
                return $this->error("tickets");
        
            return response()->json($tickets);

        }
    }
    public function store(Request $request) { 
        $user = auth()->user();
        if(!$user)
            return response()->json(['error' => 'Unauthorized'], 401);
        if(!$user->hasRole(['moderator', 'administrator'])) 
            return response()->json(['error' => 'Unauthorized'], 403);

        try {
        foreach($request->tickets as $ticket) {
            $price = $ticket['price'] * 1000;
            $unit = Ticket::create([
                'row_id' => $ticket['row_id'],
                'place_id' => $ticket['place_id'],
                'category_id' => $ticket['category_id'],
                'seance_id' => $request->seance_id,
                'price' => $price   
            ]);
        }
        return response()->json(['message' => 'Ticket successfully create'], 200);    
        }
        catch(Exception $e) {
            return response()->json(['message' => 'error ticket create'], 1451);
        }
    }
    public function updateRootTickets($id, Request $request) {
        $user = auth()->user();
        if(!$user)
            return response()->json(['error' => 'Unauthorized'], 401);
        if(!$user->hasRole(['moderator', 'administrator'])) 
            return response()->json(['error' => 'Unauthorized'], 403);

        try {
        foreach($request->tickets as $ticket) {
            $price = $ticket['price'] * 1000;
            DB::table('tickets')->where('id', $ticket['id'])->update(
                [
                'row_id' => $ticket['row_id'],
                'place_id' => $ticket['place_id'],
                'category_id' => $ticket['category_id'],
                'seance_id' => $request->seance_id,
                'price' => $price   
                ]
            );
        }
        return response()->json(['message' => 'Ticket successfully update'], 200);    
        }
        catch(Exception $e) {
            return response()->json(['message' => 'error update create'], 1451);
        }
    }
    public function update($id, Request $request) {
        $ticket = DB::table('tickets')->where('id', $id)->update($request->all());
        if(!$ticket) {
            return response()->json(['message' => 'Данные успешно обновлены', 'status' => '404']);
        }
        return response()->json(['message' => $ticket]);
    }
    public function updateTicketsStatus($id, Request $request) {
        $user = auth()->user();
        if($user && $user->hasRole(['user'])) {
            if(!$request->has('user_id')) {
                $ticket = DB::table('tickets')->where('id', $id)->update(['status' => $request->status, 'user_id' => $user->id]);
            }
            else {
                $ticket = DB::table('tickets')->where('id', $id)->update($request->all());
            }
            if(!$ticket) {
                return response()->json(['message' => 'Данные не обновлены', 'status' => '404']);
            }
            return response()->json(['message' => $ticket]);    
        }
        else {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }            
    public function put($id, Request $request) {
        //Devices::find($id)->update(['deleted' => 1]);
        return response()->json(compact($id, $request));
    }

    public function destroy($id) { }

    public function show($id) {

    }
 
    public function getUserTickets() {
        $user = auth()->user();
        if($user && $user->hasRole(['user'])) {
            $tickets = $this->t_rep->get('*', FALSE, [['user_id', '=', $user->id]]);
            if(is_null($tickets)) 
                return $this->error("tickets");
        
            return response()->json($tickets);
        } else {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }
}           
