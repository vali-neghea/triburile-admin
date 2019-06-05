<?php

namespace App\Http\Controllers;

use App\Jobs\TestJob;
use App\Services\UserService;
use App\User;
use App\Village;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        //update last request
        $this->userService->updateLastRequest($user->id);

        if (!$user) {
            $res['success'] = false;
            $res['message'] = 'Your email or password incorrect!';
            return response($res);
        }

        if ($hasher->check($password, $user->password)) {
            //create login api token
            $api_token = sha1(time());
            $create_token = User::where('id', $user->id)->update(['api_token' => $api_token]);

            $user->api_token = $create_token;

            if ($create_token) {

                $response = array(
                    'status' => 200,
                    'message' => 'User connected',
                    'success' => 1,
                    'user' => $user,
                    'villages' => Village::where('user_id',$user->id)->get(),
                );

                return response()->json($response);
            }
        }

        $res['success'] = true;
        $res['message'] = 'You email or password incorrect!';

        return response($res);
    }

    public function logout(Request $request)
    {
        $apiToken = $request->apiToken;
        $user = User::where('api_token', $apiToken)->first();

        if ($user->api_token == $apiToken) {
            $user->api_token = null;
            $user->save();

            $response = array(
                'status' => 200,
                'message' => 'User dissconected',
                'success' => 1
            );
            return response()->json($response);
        } else {
            $response = array(
                'status' => 200,
                'message' => 'The api_token or/and id is wronged',
                'success' => 0
            );
            return response()->json($response);
        }

    }
}
