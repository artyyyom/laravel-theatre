<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Repositories\RowsPlacesRepository;

class RowPlaceController extends SiteController
{
    public function __construct(RowsPlacesRepository $rp_rep) {
    	parent::__construct(new \App\Repositories\NavbarsRepository(new \App\Navbar));

    	$this->rp_rep = $rp_rep;
    }

    public function index(Request $request) {
        $stage_id = $request->input('stage_id');
        $rows_places = $this->rp_rep->get('*', FALSE, [['stage_id', '=', $stage_id]]);
        if(is_null($rows_places)) 
                return $this->error("rows_places");
        return response()->json($rows_places);
    }
    public function show($id) {
        $rows_places = $this->rp_rep->get('*', FALSE, [['stage_id', '=', $id]]);
        if(is_null($rows_places)) 
            return response()->json($this->error);

    	return [
    		response()->json($rows_places),
    		'status' => '200 OK'
    	];
    }
}
