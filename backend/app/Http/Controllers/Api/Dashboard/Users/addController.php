<?php

namespace App\Http\Controllers\Api\Dashboard\Users;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\Role;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\Request;
use App\Traits\GeneralTrait;


class addController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;
    use GeneralTrait;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */

     //RouteServiceProvider::HOME ** in protected $redirectTo
    protected $redirectTo = '';
    protected $auth;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(JWTAuth $auth)
    {
        //$this->middleware('guest');
        $this->auth = $auth;
    }


    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $validator = $this->validator($request->all());
       
        if (!$validator->fails()) {
            $user = $this->create($request->all());
            $token = JWTAuth::attempt($request->only('email', 'password'));
            return $this-> returnDataWithToken('user_data',$user,'token',$token ,"Added successfully");
            
        }
       return $this->returnError('E422',$validator->errors(),'Error Register',422);
          
       
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:150', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
            'country_code' => ['required', 'string', 'max:5'],
            'mobile' => ['required', 'string', 'max:11','unique:users'],
            'discount_code' => ['required', 'string', 'max:25'],
            'status' => ['required', 'string', 'max:25'],
            'role' => ['required', 'string'],
            
            //, 'confirmed' // for password'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
         
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'country_code' => $data['country_code'],
            'mobile' => $data['mobile'],
            'discount_code' => $data['discount_code'],
            'status' => $data['status'],
            
        ]);
        $role = Role::select('id')->where('name', ['name' => $data['role']])->first();
        $user->roles()->attach($role);
        return $user;
    }
}
