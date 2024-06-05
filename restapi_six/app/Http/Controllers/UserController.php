<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redis;

class UserController extends Controller
{
    //register 
    public function register(Request $request){
        $fields = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8',
            'password_confrimation' => 'required|same:password'
        ]);

        //save on database
        $user =  User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password'])
        ]);

        //create token
        $token = $user->createToken('mytoken')->PlainTextToken;
        // $token = $user->createToken('mytoken')->plainTextToken;

        //create response
        $response = [
            'user' => $user,
            'token' => $token
        ];
        return response( $response, 201);
        
    }
    //login
    public function login(Request $request){
        $fields = $request->validate([
         
            'email' => 'required|email',
            'password' => 'required',
          
        ]);

        //save on database
        $user = User::where('email' , $fields['email'])->first();

        if(!$user || !Hash::check($fields['password'] , $user->password)){
            return response([
                'message' => 'invaild user'
            ] , 401);
        }

        //create token
        $token = $user->createToken('mytoken')->plainTextToken;

        //create response
        $response = [
            'user' => $user,
            'token' => $token
        ];
        return response( $response, 201);
        
    }
    //logout
    public function logout(Request $request ){
        $request->user()->Tokens()->delete();
        return response([
            'message' => 'logout'
        ]);
    }
}
