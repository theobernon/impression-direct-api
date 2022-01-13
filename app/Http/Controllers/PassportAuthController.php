<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class PassportAuthController extends Controller
{
       public function register(Request $request)
       {
           $this->validate($request, [
               'name' => 'required|min:4',
               'email' => 'required|min:4',
               'password' => 'required|min:4',
               ]);

               //dd($request);
           $user = User::create([
               'name' => $request->name,
               'email' => $request->email,
               'password' => bcrypt($request->password),
           ]);

           $token = $user->createToken('LaravelAuthApp')->accessToken;

           return response()->json(['token' => $token], 200);
       }

       public function login(Request $request)
       {
           $data = [
               'email' => $request->email,
               'password' => $request->password
           ];

           if (auth()->attempt($data)) {
               $token = auth()->user()->createToken('LaravelAuthApp')->accessToken;
               return response()->json(['token' => $token, 'id' => $request->user()->id ], 200);
           } else {
               return response()->json(['error' => 'Unauthorised'], 401);
           }
       }
}
