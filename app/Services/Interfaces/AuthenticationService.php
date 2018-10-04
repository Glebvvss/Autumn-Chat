<?php 

namespace App\Services\Interfaces;

use Illuminate\Http\Request;

interface AuthenticationService
{
    public function login(Request $request);

    public function registration(Request $request);
}