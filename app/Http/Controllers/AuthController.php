<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    public function register(Request $request){

      //Validate the Inputs
        $input = $request->validate([
            'firstname'=> 'required|string',
            'lastname' => 'required|string',
            'phone_number' => 'required|string|max:11|min:11|unique:users,phone_number',
            'email'=> 'required|string|unique:users,email|email',
            'password' => ['required', 'string', Password::min(8)
                          ->mixedCase()->letters()->numbers()->symbols()->uncompromised()
                          ]
        ]);

       // Pass the input to the User DB
        $user = User::create([
          'firstname' => $input['firstname'],
          'lastname' => $input['lastname'],
          'phone_number' => $input['phone_number'],
          'email' => $input['email'],
          'password' => bcrypt($input['password'])
        ]);
        
       // $token = $user->createtoken('usertoken')->plainTextToken;

        $response = [
            'user' => $user,
            //'token' => $token
        ];

        return response($response, 201);

    }

    public function login(Request $request){

        //Validate the Inputs
          $input = $request->validate([
              'email'=> 'required|string',
              'password' => 'required|string'
          ]);
         
          //check the email
          $user = User::where('email', $input['email'])->first();

          //check the password
         if(!$user || !Hash::check($input['password'], $user->password)){
            return response([
                'message' => 'Invaild Credentials'
            ], 401);
          }

          $token = $user->createtoken('usertoken')->plainTextToken;

          $response = [
              'user' => $user,
              'token' => $token
          ];
  
          return response($response, 201);
  
      }
}
