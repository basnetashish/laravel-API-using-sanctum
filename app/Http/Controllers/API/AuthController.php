<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request){
        $validator= validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required|unique:users,email',
            'password' => 'required',
            'c_password' => 'required|same:password',

        ]);
        // if($validator->fails()){
        //     return response()->json([
        //         'success'=> false,
        //         'error' => $validator->errors()

        //     ],404);
        // }
        // else{
            $input = $request->all();
            $input['password'] = bcrypt($input['password']);
            $user= User::create($input);
            $token = $user->createToken('auth')->plainTextToken;

            return response()->json([
                'success'=> true,
                'data' => $user,
                'token' => $token,
                'message' => "User registered successfully"

            ]);
        // }
    }
    public function  login(Request $request){
        $validator = validator:: make($request->all(),[
            'email' => 'required|unique:users,email',
            'password' => 'required',

        ]);
        // if($validator->fails()){
        //         return response()->json([
        //             'success'=> false,
        //             'error' => $validator->errors()
    
        //         ],404);
        //     }
        //     else{
                if(Auth::attempt(['email' => $request->email , 'password' =>$request->password ])){
                        $user = Auth::user();
                        $token = $user->createToken('auth')->plainTextToken;

                        return response()->json([
                            'success'=> true,
                            // 'data' => $user,
                            'token' => $token,
                            'message' => "User login successfully"
            
                        ]);

                } else{
                    return response()->json([
                        'success'=> false,
                        
                        'message' => "Invalid credentials",
        
                    ]);
                }
                
    
                
            } 
               
           
    // }
}
