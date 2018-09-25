<?php

namespace App\Models\Auth;

use Auth;
use Validator;
use Illuminate\Http\Request;

class Login {
    
    public function loginAction( Request $request ) : array {
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
            return [
                'errors' => $validator->errors()
            ];
        }

        return [
            'login' => 'complete'
        ];
    }

}
