<?php


namespace App\Services;


use App\User;
use Carbon\Carbon;

class UserService
{
    public function updateLastRequest($userId) {
        User::where('id',$userId)->update(['last_request' => Carbon::now()]);
    }
}
