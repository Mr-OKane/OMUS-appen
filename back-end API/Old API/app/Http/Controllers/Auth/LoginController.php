<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use http\Env\Response;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class LoginController extends Controller
{
    /**
     *  checks login credentials
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function authentiacte(Request $request){

        //validates email and password
        $credentials = $this->validate($request,[
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

        //gets the user
        $user = User::firstWhere('email','=',$request->email);

        if (Auth::guard('api')->attempt($credentials)) {
            $token = $user->createToken('jwt token');
            return response()->json(['token' => $token->plainTextToken],200);
        }

        //if the login fails
        Auth::logout();
        return response()->json(['error' => "The provided credentials do not match our records."],401);
    }

    /**
     * logs a user out of the system
     * @return RedirectResponse
     */
    public function logout()
    {
        Auth::logout();
        return redirect()->intended('login');
    }
}
