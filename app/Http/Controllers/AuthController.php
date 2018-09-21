<?php

namespace App\Http\Controllers;

use Auth;
use Hash;
use Validator;
use Illuminate\Http\Request;
use App\Models\Eloquent\User;

class AuthController extends Controller
{
    public function login(Request $request) {
    	$validator = Validator::make($request->all(), [
    		'username' => 'required',
    		'password' => 'required'
    	]);        

        $validator->after(function($validator) use ($request) {
            if ( !Auth::attempt(['username' => $request->username, 
                                 'password' => $request->password ])) {
                
                $validator->errors()->add('password', 'Incorrect username or password');
            }
        });

        if ( $validator->fails() ) {
            return response()->json([
                'errors' => $validator->errors()
            ]); 
        }

        return response()->json([
            'login' => 'complete'
        ]);
    }

    public function registration(Request $request) {
        $validator = Validator::make($request->all(), [
            'username'        => 'required|unique:users',
            'email'           => 'required|email|unique:users',
            'password'        => 'required',
            'confirmPassword' => 'required',
        ]);

        $validator->after(function($validator) use ($request) {
            if ( $request->password !== $request->confirmPassword ) {
                $validator
                    ->errors()
                    ->add('confirmPassword', 'Password fields in not match.');
            }
        });

        if ( $validator->fails() ) {
            return response()->json([
                'errors' => $validator->errors()
            ]);
        }

        $user = new User();
        $user->username = $request->username;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();

        if ( !Auth::attempt(['username' => $request->username, 
                             'password' => $request->password ])) {

            return response()->json([
                'login' => 'Login failed'
            ]);
        }
            
        return response()->json([
            'login' => 'complete'
        ]);
    }

    public function checkRoleUser() {
        if ( Auth::check() ) {
            return response()->json([
                'role' => 'user'
            ]);
        }
        return response()->json([
            'role' => 'guest'
        ]);

    }

    public function logout() {
    	if ( Auth::check() ) {
    		Auth::logout();
    	}
    }
}
