<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function getUsername() {
      return response()->json([
        'username' => Auth::user()->username
      ]);
    }

    public function getId() {
      return response()->json([
        'userId' => Auth::user()->id
      ]);
    }
}
