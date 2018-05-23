<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Repositories\RolesRepository;

class RoleController extends SiteController
{
    public function __construct(RolesRepository $rl_rep) {
    	parent::__construct(new \App\Repositories\NavbarsRepository(new \App\Navbar));
        $this->rl_rep = $rl_rep;
    }

    public function getRoles() {
        $user = auth()->user();
        if(!$user)
            return response()->json(['error' => 'Unauthorized'], 401);
        if(!$user->hasRole(['administrator'])) 
            return response()->json(['error' => 'Unauthorized'], 403);

        $roles = $this->rl_rep->get();
        if(is_null($roles)) 
            return $this->error("roles");

        return response()->json($roles);
    }
}