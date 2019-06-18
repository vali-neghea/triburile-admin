<?php


namespace App\Services;


use App\Models\User;
use Carbon\Carbon;

class UserService
{
    public function updateLastRequest($userToken) {
        User::where('api_token',$userToken)->update(['last_request' => Carbon::now()]);
    }
}
