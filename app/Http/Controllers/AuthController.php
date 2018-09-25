<?php

namespace App\Http\Controllers;

use Auth;
use Hash;
use Validator;
use Illuminate\Http\Request;
use App\Models\Eloquent\User;
use App\Models\Auth\Authenticate;

class AuthController extends Controller {

    public function login(Request $request) {
        $result = Authenticate::login($request);
        return response()->json($result);
    }

    public function registration(Request $request) {
        $errors = Authenticate::registration($request);

        if ( !empty($errors) ) {
            return response()->json($errors);
        }

        $result = $this->login($request);
        return response()->json($result);
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
