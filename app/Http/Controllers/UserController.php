<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function register(Request $request) {
        $name = $request->name;
        $email = $request->email;
        $password = $request->password;

        
        if(count(User::where('email','=', $email)->get()) <= 0) {
            $user = new User();
            
            $user->name = $name;
            $user->email = $email;
            $user->password = Hash::make($password);

            $user->save();

            $response = [
                'user' => $user,
                'status' => 200,
                'success' => 1
            ];

            return response()->json($response);
        }else {
            $response = [
                'status' => '200',
                'success' => 0,
                'message' => 'This email is already in use.'
            ];

            return response()->json($response);
        }
    }

    public function edit(Request $request, $id) {
        $user = User::find($id);
        $user->update($request->all());

        return response()->json($user);
    }
}
