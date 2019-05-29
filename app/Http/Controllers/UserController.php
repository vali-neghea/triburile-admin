<?php

namespace App\Http\Controllers;

use App\Continent;
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

        $continent = Continent::where('villages','<=','max_villages')->first();

        if(count($continent) <= 0) {
            $response = [
                'status' => 200,
                'message' => 'The map is full.Try on another map or wait for us to create a new one.',
                'success' => 0
            ];

            return response()->json($response);
        }
        
        if(count(User::where('email','=', $email)->get()) <= 0) {
            $user = new User();
            
            $user->name = $name;
            $user->email = $email;
            $user->password = Hash::make($password);
            $user->continent_id = $continent->id;

            $user->save();

            $continent->villages += 1;
            $continent->save();



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

    public function getAll() {
        $usersRaw = User::all();
        $users = array();

        foreach ($usersRaw as $key => $user) {
            $users[$key]['id'] = $user->id;
            $users[$key]['name'] = $user->name;
            $users[$key]['email'] = $user->email;
        }

        return $users;
    }
}
