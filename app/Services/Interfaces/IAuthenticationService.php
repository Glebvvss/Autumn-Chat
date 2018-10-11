<?php 

namespace App\Services\Interfaces;

use Illuminate\Http\Request;

interface IAuthenticationService
{
    public function login(Request $request);

    public function registration(Request $request);
}