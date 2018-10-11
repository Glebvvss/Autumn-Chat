<?php 

namespace App\Services\Realizations;

use Auth;
use Hash;
use Validator;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\Interfaces\IAuthenticationService;

class AuthenticationService implements IAuthenticationService
{

    public function login(Request $request) : array
    {
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

    public function registration(Request $request) : array
    {
        $errors = $this->validateRegistrationRequest($request);

        if ( $errors ) {
            return $errors;
        }
        
        $this->addNewUserModelToDb($request);
        return [];
    }

    private function validateRegistrationRequest( Request $request ) : array 
    {
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

    private function addNewUserModelToDb(Request $request) 
    {
        $user = new User();
        $user->username = $request->username;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();
    }
  
}