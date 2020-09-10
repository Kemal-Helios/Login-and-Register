<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
class MyController extends Controller
{
    protected $auth;
    public function __construct(JWTAuth $auth){
        $this->auth = $auth;
    }
    public function index(REQUEST $request){
        return response()->json([
            'success'   =>  true,
            'data'  =>  $request->user()
        ]);
    }
    public function logout(REQUEST $request){
        JWTAuth::invalidate();
        return response()->json([
            'success'   =>  true
        ]);
    }
}
