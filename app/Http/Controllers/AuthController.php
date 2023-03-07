<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request){
        $fields = $request->validate([
            'id'=>'required|string|unique:users,id',
            'fName' =>'required|string',
            'lName' =>'required|string',
            'email' =>'required|string|unique:users,email',
            'password' =>'required|string|confirmed',
            'phone' => 'required',
            'address' =>'required|string',
        ]);
        $user = User::create([
            'id' =>$fields['id'],
            'fName' => $fields['fName'],
            'lName' =>$fields['lName'],
            'email' =>$fields['email'],
            'password' => bcrypt( $fields['password']),
            'phone' =>$fields['phone'],
            'address' =>$fields['address'],
        ]);

        $token = $user->createToken('myapptoken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token,
        ];

        return response($response ,201);
    }

    public function login(Request $request){
        $fields = $request->validate([
            'email' =>'required|string',
            'password' =>'required|string',
        ]);

        $user =  User::where('email' , $fields['email'])->first();

        if(!$user || !Hash::check($fields['password'], $user->password)){
            return response([
                'messege'=> 'Bad Try'
            ], 401);
        }
        $token = $user->createToken('myapptoken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token,
        ];

        return response($response ,200);
    }

    public function logout(Request $request){
        auth()->user()->tokens()->delete();
        return [
            'message'=>'Logged out'
        ];
    }
}
