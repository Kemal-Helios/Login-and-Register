<?php

namespace App\Http\Controllers\Api\Dashboard\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use App\Traits\GeneralTrait;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Gate;

class usersController extends Controller
{
    use GeneralTrait;
    protected $auth;
    public function __construct(JWTAuth $auth){
        $this->auth = $auth;
    }

    public function homePage(REQUEST $request){
        return $this -> returnData('data',$request->user(),'Saccess');
    }

    public function store()
    {
        /*
        if(Gate::denies('administration')){
            return $this->returnError('E004', '', 'your position here unauthorization', 401);
        }
        */
        $users = User::with('roles')->orderBy('id','DESC')->get();
        
        return $this -> returnData('users',$users,'Saccess');
    }


    public function update(REQUEST $request)
    {
        $user = User::find($request->userId);
        
        if (!$user) {
            return $this->returnError('E0007',['Request' => ['There is a server error please check with the developer']], 'Error', 500);
        }
        if($request->password == ''){ 
           $request->offsetUnset('password');   
        }
        $validator = $this->validator($request->all());
        if (!$validator->fails()) {
            $roleUser = Role::where('name', $request->role)->first();
            $user->roles()->sync($roleUser);
            $user->fill($request->all())->save();
            
            return $this -> returnSuccessMessage('SU001','Member has been successfully updated');
        }
       return $this->returnError('E422',$validator->errors(),'Error Register',422);
        
       
    }
    protected function validator(array $data ) 
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'max:150', 'unique:users,email,'.$data['id']],
            //'password' => ['string', 'min:8'],
            'country_code' => ['required', 'string', 'max:5'],
            'mobile' => ['required', 'string', 'max:11','unique:users,mobile,'.$data['id']],
            'discount_code' => ['required', 'string', 'max:25'],
            'status' => ['required', 'string', 'max:25'],
            'role' => ['required', 'string'],
        ]);
    }

    public function destroy(REQUEST $request){

        $user = User::find($request->userId);
        $roleUser = Role::where('name', $request->role)->first();
        $user->roles()->sync($roleUser);
        $user->delete();
        return response()->json([
          'message' => 'Data deleted successfully!'
        ]);
  
  }
    public function logout(REQUEST $request){
        JWTAuth::invalidate();
        return $this->returnSuccessMessage('S001', 'Goodbye, we await your return');
    }
}
