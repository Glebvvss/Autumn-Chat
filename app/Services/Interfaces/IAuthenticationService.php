<?php 

namespace App\Services\Interfaces;

use Illuminate\Http\Request;

interface IAuthenticationService
{
    public function login(Request $request) : array;

    public function registration(Request $request) : array;
}