<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\EmployeesRepository;
use Illuminate\Support\Facades\Validator;
use DB;
use App\Employee;
use Storage;
class EmployeeController extends SiteController
{
    public function __construct(EmployeesRepository $e_rep) {
    	parent::__construct(new \App\Repositories\NavbarsRepository(new \App\Navbar));

    	$this->e_rep = $e_rep;
    }

    public function getOneProfession($id) {
        $employee = $this->e_rep
            ->get('*', FALSE, ['position_id','=',$id]);

        if(is_null($employee)) 
            return $this->error("employee");

    	return response()->json(['data' => $employee, 'status' => '200']);
    }

    public function index(Request $request) {
        $employees = $this->e_rep->get();
        if(is_null($employees)) 
            return $this->error("employees");
        $employees->load('positions', 'unit');
        return response()->json($employees);
    }
    public function store(Request $request) { 
        $user = auth()->user();
        if(!$user)
            return response()->json(['error' => 'Unauthorized'], 401);
        if(!$user->hasRole(['moderator', 'administrator'])) 
            return response()->json(['error' => 'Unauthorized'], 403);
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'surname' => 'required',
            'middlename' => 'required',
            'address' => 'required',
            'birthday' => 'required|date',
            'biography' => 'required',
            'biography_short' => 'required',
            'mobile_number' => 'required',
            'photo' => 'required',
            'photos' => 'required'

        ]);
        if($validator->fails()) {
            return response()->json($validator->errors());
        }
    
        try {
        $employee = Employee::create([
            'name' => $request->name,
            'surname' => $request->surname,
            'middlename'=> $request->middlename, 
            'address' => $request->address,
            'birthday' => $request->birthday,
            'biography' => $request->biography,
            'biography_short' => $request->biography_short,
            'mobile_number' => $request->mobile_number,
            'photo_main' => $request->photo,
            'photos' => $request->photos,
            'unit_id' => $request->unit
        ]);
        foreach($request->positions as $position)    
            $employee->positions()->attach($position['id']);
    
        return response()->json(['message' => 'Employee successfully create'], 200);    
        }
        catch(Exception $e) {
            return response()->json(['message' => 'error employee create'], 1451);
        }
    }

    public function update($id, Request $request) { 
        $user = auth()->user();
        if(!$user)
            return response()->json(['error' => 'Unauthorized'], 401);
        if(!$user->hasRole(['moderator', 'administrator'])) 
            return response()->json(['error' => 'Unauthorized'], 403);

        try {
            $employee = Employee::find($id);
            $employeeUpdate = DB::table('employees')->where('id', $id)
                    ->update(['name' => $request->name,
                    'surname' => $request->surname,
                    'middlename'=> $request->middlename, 
                    'address' => $request->address,
                    'birthday' => $request->birthday,
                    'biography' => $request->biography,
                    'biography_short' => $request->biography_short,
                    'mobile_number' => $request->mobile_number,
                    'photo_main' => $request->photo,
                    'photos' => $request->photos,
                    'unit_id' => $request->unit]);

            DB::table('employees_positions')->where('employee_id', $id)->delete();
            foreach($request->positions as $position)    
                $employee->positions()->attach($position['id']);
    
            return response()->json(['message' => 'Employee update succesfully'], 200); 
            }
            catch(Exception $e) {
                return response()->json(['message' => 'error employee update'], 1451);
            }
    }

    public function destroy($id) { 
        $user = auth()->user();
        if(!$user)
            return response()->json(['error' => 'Unauthorized'], 401);
        if(!$user->hasRole(['moderator', 'administrator'])) 
            return response()->json(['error' => 'Unauthorized'], 403);
        try {
            $employee = Employee::find($id)->delete();
            return response()->json(['message' => 'Employee succsessfully delete'], 200);
        }
        catch(Exception $e) {
            return response()->json(['message' => 'Employee restrict delete'], 1451);
        }
    }

    public function show($id) {
        $employee = $this->e_rep->one($id);
        if(is_null($employee)) 
            return $this->error("employee");
        $employee->load('performances', 'positions', 'unit');
    //    $employee->pivot->role;
        return response()->json($employee);
    }
 
    public function uploadEmployeePhotos(Request $request) {
        $user = auth()->user();
        if(!$user)
            return response()->json(['error' => 'Unauthorized'], 401);
        if(!$user->hasRole(['moderator', 'administrator'])) 
            return response()->json(['error' => 'Unauthorized'], 403);
        if ($request->hasFile('photo')) {
          $filename = $request->photo->getClientOriginalName();
          $request->photo->move(base_path('public/images/employees'), $filename);
          return response()->json(['message' => 'Photo successfully upload'], 200);
        }
        if ($request->hasFile('photos')) {
            foreach($request->photos as $photo) {
                $filename = $photo->getClientOriginalName();
                $photo->move(base_path('public/images/employees'), $filename);   
            }
            return response()->json(['message' => 'Photos successfully upload'], 200);
        }
    }
}           
