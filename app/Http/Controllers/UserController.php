<?php

namespace App\Http\Controllers;

use App\Continent;
use App\Helpers\ResponseHelper;
use App\Services\VillageService;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    protected $villageService;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(VillageService $villageService)
    {
        $this->villageService = $villageService;
    }

    public function register(Request $request) {
        $name = $request->name;
        $email = $request->email;
        $password = $request->password;

        $continent = Continent::whereRaw('continents.villages < continents.max_villages')->first();

        if(!$continent) {

            return ResponseHelper::responseJson(200,0,'The map is full.Try on another map or wait for us to create a new one.','');
        }

        if(count(User::where('email','=', $email)->get()) <= 0) {

            /**
             * get last User details */
            $lastUser = User::orderBy('id','desc')->first();

            if($lastUser) {
                $lastUserX = $lastUser->x_coordinates;
                $lastUserY = $lastUser->y_coordinates;

                $x_coordinates = rand($lastUserX + 1,$lastUserX + 5);
                $y_coordinates = rand($lastUserY + 1, $lastUserY + 5);

            }else {
                $x_coordinates = 0;
                $y_coordinates = 0;
            }

            /** store new User */
            $user = new User();
            
            $user->name = $name;
            $user->email = $email;
            $user->password = Hash::make($password);
            $user->save();

            /** create new xOy coordinates for village */

            $villageId = $this->villageService->store($user,$continent->id,$x_coordinates,$y_coordinates);
            if($this->villageService->addVillageToUser($user->id,$villageId)){
                /** increments continent's number of players */
                $continent->villages += 1;
                $continent->save();

                $data = array();
                $data['user'] = $user;
                $data['villageId'] = $villageId;

                return ResponseHelper::responseJson(200,1,'User registered with success',$data);
            }else {

                return ResponseHelper::responseJson(200,0,'Something went wrogn with creating your village','');
            }
        }else {

            return ResponseHelper::responseJson(200,0,'This email is already in use.','');
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
            $users[$key]['x'] = $user->x_coordinates;
            $users[$key]['y'] = $user->y_coordinates;
        }

        return $users;
    }
}
