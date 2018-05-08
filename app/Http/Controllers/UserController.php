<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Repositories\UsersRepository;
use App\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Validator;
class UserController extends SiteController
{
    public function __construct(UsersRepository $us_rep) {
    	parent::__construct(new \App\Repositories\NavbarsRepository(new \App\Navbar));
        $this->us_rep = $us_rep;
    }

    public function index () {
        // $users = $this->us_rep->get();
        // return response()->json($users);
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required'
        ]);
        $name = strtolower($request->name);
        $email = strtolower($request->email);
        $phone = $request->phone;
        $password = Hash::make(str_random(8));
        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'phone' => $phone,
        ]);

        return response()->json($user->id);
    }

    public function update() {

    }

    public function destroy() {
    	
    }
}
