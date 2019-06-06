<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Services\UserService;
use App\User;
use App\Village;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    protected $userService;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Login controller
     *
     * When user success login will retrive callback as api_token
     */
    public function login(Request $request)
    {
        $hasher = app()->make('hash');

        $email = $request->input('email');
        $password = $request->input('password');
        $user = User::where('email', $email)->first();

        if (!$user) {
            return ResponseHelper::responseJson(200,false,'Your email or password are incorrect!','');
        }

        if ($hasher->check($password, $user->password)) {
            //create login api token
            $api_token = sha1(time());
            $create_token = User::where('id', $user->id)->update(['api_token' => $api_token]);
            $user->api_token = $api_token;

            $data = array(
                'user' => $user,
                'villages' => Village::where('user_id',$user->id)->get()
            );

            if ($create_token) {
                return ResponseHelper::responseJson(200,1,'User connected',$data);
            }
        }

        return ResponseHelper::responseJson(200,false,'Your email or password are incorrect','');
    }

    public function logout(Request $request)
    {
        $apiToken = $request->apiToken;
        $user = User::where('api_token', $apiToken)->first();

        if ($user->api_token == $apiToken) {
            $user->api_token = null;
            $user->save();

            return ResponseHelper::responseJson(200,1,'User dissconected','');
        } else {

            return ResponseHelper::responseJson(200,0,'The api_token or/and id is wronged','');
        }

    }
}
