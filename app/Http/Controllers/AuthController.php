<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\tasks;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request){
            $user=User::where('email',$request->email)->first();
            $todolist=tasks::where('user_id',$user->id)->orderBy('created_at','desc')->get();
            if($user){
                if(Hash::check($request->password,$user->password)){
                      return response()->json([
                        'user'=>$user,
                        'token'=>$user->createToken(time())->plainTextToken,
                        'todolist'=>$todolist
                      ]);

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
            return response()->json($responses);
        }
        else{
            User::create([
                'name'=>$request->name,
                'email'=>$request->email,
                'password'=>Hash::make($request->password),

            ]);

        }
    }
}
