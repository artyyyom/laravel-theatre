<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Repositories\UsersRepository;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Mail\UserMail;
use App\Mail\RecoverMail;
use Illuminate\Support\Facades\Mail;
use DB;

class UserController extends SiteController
{
    public $successStatus;
    public function __construct(UsersRepository $us_rep) {
    	parent::__construct(new \App\Repositories\NavbarsRepository(new \App\Navbar));
        $this->us_rep = $us_rep;
        $this->successStatus = 200;
        
    }

    public function getUserById($id) {
        $user = auth()->user();
        if(!$user)
            return response()->json(['error' => 'Unauthorized'], 401);
        if(!$user->hasRole('administrator')) 
            return response()->json(['error' => 'Unauthorized'], 403);

        $userInform = User::find($id);
        $userInform->load('roles');
        return response()->json($userInform);
    }
    public function updateUser($id, Request $request) {
        $userAuth = auth()->user();
        if(!$userAuth)
            return response()->json(['error' => 'Unauthorized'], 401);
        if(!$userAuth->hasRole('administrator')) 
            return response()->json(['error' => 'Unauthorized'], 403);
        try {
        $roles = DB::table('role_user')->where('user_id', $id)->delete();
        $user = User::find($id);
        $is_update = DB::table('users')->where('id', $id)
                ->update(['name' => $request->name, 'email' => $request->email, 'phone' => $request->phone]);
        foreach($request->roles as $role) 
            $user->attachRole($role['name']); 
        
        return response()->json(['message' => 'User update succesfully'], 200); 
        }
        catch(Exception $e) {
            return response()->json(['message' => 'error user update'], 1451);
        }
    }
    public function addSuperUser(Request $request) {
        $user = auth()->user();
        if(!$user)
            return response()->json(['error' => 'Unauthorized'], 401);
        if(!$user->hasRole('administrator')) 
            return response()->json(['error' => 'Unauthorized'], 403);

            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required|email|unique:users',
                'phone' => 'required',
            ]);
            if($validator->fails()) {
                return response()->json($validator->errors());
            }
            $name = ucfirst(strtolower($request->name));
            $email = strtolower($request->email);
            $phone = $request->phone;
            $password = Hash::make("password");
            $user = User::create([
                'name' => $name,
                'email' => $email,
                'password' => $password,
                'phone' => $phone,
            ]);
            foreach($request->roles as $role) {
                $user->attachRole($role['name']);   
            }
            Mail::to($email)->send(new UserMail($user));
            return response()->json(['message' => 'User succsessfully create'], 201);
        
    }
    public function getUserByTicketId($id) {
        $user = auth()->user();
        if(!$user)
            return response()->json(['error' => 'Unauthorized'], 401);
        if(!$user->hasRole(['moderator','administrator'])) 
            return response()->json(['error' => 'Unauthorized'], 403);

        $user = User::whereIn('id', function($query) use ($id) {
            $query->select('user_id')->from('tickets')->whereRaw("tickets.id = $id");
        })->first();

        return response()->json($user);
    }
    public function getUsersByRole (Request $request) {
        $user = auth()->user();
        if(!$user)
            return response()->json(['error' => 'Unauthorized'], 401);
        if(!$user->hasRole(['moderator','administrator'])) 
            return response()->json(['error' => 'Unauthorized'], 403);

        $users = $this->us_rep->get();
        if(is_null($users)) 
            return $this->error("users");
        $array = [];
        $filter = $request->filter;
        if($filter === 'false') {
            foreach($users as $user) {
                if($user->hasRole('user')) {
                    $array[] = $user;
                }
            }
            return response()->json($array);
        }
        if($filter === 'true') {
            $users->load('roles');
            foreach($users as $user) {
                if($user->hasRole(['moderator','administrator'])) {
                    $array[] = $user;
                }
            }
            return response()->json($array);
        }
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'phone' => 'required'
        ]);
        if($validator->fails()) {
            return response()->json($validator->errors());
        }
        $name = $request->name;
        $email = mb_strtolower($request->email);
        $phone = $request->phone;
        $password = Hash::make("password");
        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'phone' => $phone,
        ]);
        $user->attachRole('user');    
        Mail::to($email)->send(new UserMail($user));
        return response()->json($user->id);
    }

    public function update() {

    }

    public function destroy($id) {
        $user = auth()->user();
        if(!$user)
            return response()->json(['error' => 'Unauthorized'], 401);
        if(!$user->hasRole('administrator')) 
            return response()->json(['error' => 'Unauthorized'], 403);
        try {
            $user = User::find($id)->delete();
            return response()->json(['message' => 'User succsessfully delete'], 200);
        }
        catch(Exception $e) {
            return response()->json(['message' => 'User restrict delete'], 1451);
        }
    }
    public function login()
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }
    public function loginAdminPanel() {
        $credentials = request(['email', 'password']);

        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        $user = auth()->user();
        if(!$user && !$user->hasRole(['moderator', 'administrator']))
            return response()->json(['error' => 'Unauthorized'], 401);
            
        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
    public function recover(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json(['message' => 'Your email address was not found'], 401);
        }
        try {
            $password = "passwords";
            $passwordEncrypt = Hash::make("passwords");
            
            User::where('email', $request->email)->update(["password" => $passwordEncrypt]);
        } catch (\Exception $e) {
            $error_message = $e->getMessage();
            return response()->json(['success' => false, 'error' => $error_message], 401);
        }
        Mail::to($request->email)->send(new RecoverMail($user, $password));
        return response()->json([
            'success' => true, 'data'=> ['message'=> 'A reset email has been sent! Please check your email.']
        ]);
    }


}
