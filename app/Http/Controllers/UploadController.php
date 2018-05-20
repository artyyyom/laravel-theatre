<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Unit;
use DB;
use App\Repositories\UnitsRepository;
use Illuminate\Support\Facades\Validator;

class UploadController extends SiteController
{
    public function __construct(UnitsRepository $u_rep) {
    	parent::__construct(new \App\Repositories\NavbarsRepository(new \App\Navbar));
        $this->u_rep = $u_rep;
    }

    public function upload(Request $request) {
        if ($request->hasFile('photo')) {
            $file = $request->photo;
            $path = $request->photo->move(public_path("/storage/employees"));
            return "ok";
        } 

        return "no";
    }
}