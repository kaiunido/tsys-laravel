<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;
use App\Http\Requests\AuthRequest;
use App\Models\User;

class AuthController extends Controller
{
  /**
   * Handle an authentication attempt
   * 
   * @param \Illuminate\Http\Request $request
   * @return \Illuminate\Http\Response
   */
  public function login(AuthRequest $request)
  {
    $credential = $request->safe()->all();

    if (!Auth::attempt($credential)) {
      return response([
        "status" => 401,
        "errors" => ["auth" => __("auth.failed")],
      ], Response::HTTP_UNAUTHORIZED);
    }

    $request->session()->regenerate();

    $user = User::select("name", "email")
      ->where("email", $credential["email"])->first();

    if ($user->tokens) {
      $user->tokens()->delete();
      unset($user["tokens"]);
    }

    $token = $user->createToken("user_session")->plainTextToken;

    return response([
      "user" => $user,
      "token" => $token,
    ], Response::HTTP_OK);
  }
}
