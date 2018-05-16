<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\CategoryPlacesRepository;
use DB;
use App\Category_Place;
use Illuminate\Support\Facades\Validator;

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

    public function show($id) {
        $category_place = $this->cp_rep->one($id);
        if(is_null($category_place)) 
            return $this->error("category_places");
        return response()->json($category_place);
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
        $category_place = Category_Place::create([
            'name' => $name
        ]);
        return response()->json(['message' => 'Category successfully update'], 200);    
        }
        catch(Exception $e) {
            return response()->json(['message' => 'Error category create'], 1451);
        }
    }

    public function update($id, Request $request) {
        $user = auth()->user();
        if(!$user)
            return response()->json(['error' => 'Unauthorized'], 401);
        if(!$user->hasRole(['moderator', 'administrator'])) 
            return response()->json(['error' => 'Unauthorized'], 403);
        try {
        $category_places = DB::table('category_places')->where('id', $id)->update($request->all());
        
        if(!$category_places)
            return response()->json(['message' => 'Table not update'], 404);

        return response()->json(['message' => 'Category update succesfully'], 200); 
        }
        catch(Exception $e) {
            return response()->json(['message' => 'Error category update'], 1451);
        }
    }

    public function destroy($id) {
    	$user = auth()->user();
        if(!$user)
            return response()->json(['error' => 'Unauthorized'], 401);
        if(!$user->hasRole(['moderator', 'administrator'])) 
            return response()->json(['error' => 'Unauthorized'], 403);
        try {
            $unit = Category_Place::find($id)->delete();
            return response()->json(['message' => 'Category succsessfully delete'], 200);
        }
        catch(Exception $e) {
            return response()->json(['message' => 'Category restrict delete'], 1451);
        }
    }
}
