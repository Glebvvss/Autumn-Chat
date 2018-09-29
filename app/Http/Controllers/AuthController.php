<?php

namespace App\Http\Controllers;

use Auth;
use Hash;
use Validator;
use App\ORM\Eloquent\User;
use Illuminate\Http\Request;
use App\Services\Interfaces\Authentication;

class AuthController extends Controller {

    private $authentication;

    public function __construct(Authentication $authentication) {
        $this->authentication = $authentication;
    }

    public function login(Request $request) {
        $result = $this->authentication->login($request);
        return response()->json($result);
    }

    public function registration(Request $request) {
        $errors = $this->authentication->registration($request);

        if ( !empty($errors) ) {
            return response()->json($errors);
        }

        //$result = $this->login($request);
        //return response()->json($result);
    }

    public function checkLogin() {
        if ( Auth::check() ) {
            return response()->json([
                'status' => 'user'
            ]);
        }
        return response()->json([
            'status' => 'guest'
        ]);
    }

    public function logout() {
        if ( Auth::check() ) {
            Auth::logout();
        }
    }

}
