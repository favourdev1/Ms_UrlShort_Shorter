<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{
  function AuthenticateUser(Request $request)
  {
    $user = auth()->user();

    if (!$user) {
      return response()->json(['message' => 'Unauthorized User Access', 'status' => false], 401);
    }

    // // User is authenticated, proceed with the action
    // return response()->json(['message' => 'Authenticated', 'status' => true]);
  }
}