<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Repositories\UsersRepository;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Mail\UserMail;
use Illuminate\Support\Facades\Mail;


class UserController extends SiteController
{
    public $successStatus;
    public function __construct(UsersRepository $us_rep) {
    	parent::__construct(new \App\Repositories\NavbarsRepository(new \App\Navbar));
        $this->us_rep = $us_rep;
        $this->successStatus = 200;
        
    }


    public function index () {
        // $users = $this->us_rep->get();
        // return response()->json($users);
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
        $name = strtolower($request->name);
        $email = strtolower($request->email);
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

    public function destroy() {
    	
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
    
    // public function login(Request $request){
    
    //     if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
    //         $user = Auth::user();
    //         $success['token'] =  $user->createToken('MyApp')->accessToken;
    //         return response()->json(['success' => $success], $this->successStatus);
    //     }
    //     else{
    //         return response()->json(['error'=>'Unauthorised'], 401);
    //     }
    // }


    // /**
    //  * Register api
    //  *
    //  * @return \Illuminate\Http\Response
    //  */
    // public function register(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'name' => 'required',
    //         'email' => 'required|email',
    //         'password' => 'required',
    //         'phone' => 'required',
    //         'c_password' => 'required|same:password',
    //     ]);


    //     if ($validator->fails()) {
    //         return response()->json(['error'=>$validator->errors()], 401);            
    //     }

        
    //     $input = $request->all();
    //     $input['password'] = bcrypt($input['password']);
    //     $user = User::create($input);
    //     $success['token'] =  $user->createToken('MyApp')->accessToken;
    //     $success['name'] =  $user->name;


    //     return response()->json(['success'=>$success], $this->successStatus);
    // }


    // /**
    //  * details api
    //  *
    //  * @return \Illuminate\Http\Response
    //  */
    // public function details()
    // {
    //     $user = Auth::user();
    //     return response()->json(['success' => $user], $this->successStatus);
    // }
    
}
