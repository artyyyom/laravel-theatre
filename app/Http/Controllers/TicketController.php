<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\TicketsRepository;
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
    public function store() { }

    public function update($id, Request $request) {
        $ticket = DB::table('tickets')->where('id', $id)->update($request->all());
        if(!$ticket) {
            return response()->json(['message' => 'Данные успешно обновлены', 'status' => '404']);
        }
        return response()->json(['message' => $ticket]);
    }

    public function put($id, Requst $request) {
        //Devices::find($id)->update(['deleted' => 1]);
        return response()->json(compact($id, $request));
    }

    public function destroy($id) { }

    public function show($id) {

    }
 

}           
