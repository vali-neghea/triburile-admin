<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Models\User;

class ExampleController extends Controller
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

    public function test() {
        return ResponseHelper::responseJson(200,1,'Poti s-o indoi fara s-o inmoi?','');
    }

    public function textIndex(){
        $users = User::all();
        $data = array();

        foreach ($users as $key => $user) {
            $data[$key]['user'] = $user;
            foreach ($user->villages as $village) {
                if($village) {
                    $data[$key]['user']['village'] = $village;
                }
            }
        }

        return ResponseHelper::responseJson(200,1,'Details about users',$data);
    }
}
