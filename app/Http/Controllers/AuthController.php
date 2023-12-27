<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request){
            $user=User::where('email',$request->email)->first();
            if($user){
                if(Hash::check($request->password,$user->password)){
                      return response()->json([
                        'user'=>$user,
                        'token'=>$user->createToken(time())->plainTextToken]);
                }
                else{
                    return response()->json(['unauthorized'=>'there is no user',500]);
                }
            }

    }
    public function register(Request $request){
        $user=User::where('email',$request->email)->first();
        if($user){
            $responses=['message'=>'this email has already exist'];
            return response()->json($responses, 300);
        }
        else{
            User::create([
                'name'=>$request->name,
                'email'=>$request->email,
                'password'=>Hash::make($request->password),
                'role'=>'admin'
            ]);
            $newuser=User::where('email',$request->email)->first();
            return response()->json([
                'user'=>$newuser,
                'token'=>$newuser->createToken(time())->plainTextToken
            ]);
        }
    }
}
