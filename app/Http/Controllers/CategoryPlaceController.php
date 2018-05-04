<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\CategoryPlacesRepository;

class CategoryPlaceController extends SiteController
{
    public function __construct(CategoryPlacesRepository $cp_rep) {
        parent::__construct(new \App\Repositories\NavbarsRepository(new \App\Navbar));
        
        $this->cp_rep = $cp_rep;
    }

    public function index () {
        $category_places = $this->cp_rep->get();
        if(is_null($category_places)) 
            return $this->error("category_places");

    	return response()->json($category_places);
    }

    public function store() {

    }

    public function update() {

    }

    public function destroy() {
    	
    }
}
