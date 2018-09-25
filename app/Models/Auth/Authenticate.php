<?php

namespace App\Models\Auth;

use Auth;
use Validator;
use Illuminate\Http\Request;

class Authenticate {

    public static function registration( Request $request ) : array {
        $registration = new Registration();
        return $registration->registrationAction($request);
    }

    public static function login( Request $request ) : array {
        $login = new Login();
        return $login->loginAction($request);
    }

}
