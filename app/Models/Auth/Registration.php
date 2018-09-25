<?php

namespace App\Models\Auth;

use Auth;
use Hash;
use Validator;
use Illuminate\Http\Request;
use App\Models\Eloquent\User;

class Registration {
    
    public function registrationAction( Request $request ) : array {
        $errors = $this->validateRegistrationRequest($request);

        if ( $errors ) {
            return $errors;
        }
        
        $this->addNewUserModelToDb($request);
        return [];
    }

    private function validateRegistrationRequest( Request $request ) : array {
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
            return [
                'errors' => $validator->errors()
            ];
        }
        
        return [];
    }

    private function addNewUserModelToDb( Request $request ) {
        $user = new User();
        $user->username = $request->username;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();
    }

}
