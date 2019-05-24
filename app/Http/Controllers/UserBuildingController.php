<?php
/**
 * Created by PhpStorm.
 * User: Andy
 * Date: 5/24/2019
 * Time: 1:05 PM
 */

namespace App\Http\Controllers;


use App\Building;
use App\Troop;
use App\UserBuilding;
use Illuminate\Http\Request;

class UserBuildingController extends Controller
{
    public function store(Request $request) {
        $userId = $request->user_id;
        $buildingId = $request->building_id;
        $buildingLevel = $request->level;

        $sameBuilding = UserBuilding::where('user_id','=',$userId)
                                    ->where('building_id','=',$buildingId)
                                    ->get();

        if(count($sameBuilding) > 0) {
            $response = array(
                'status' => 200,
                'message' => 'This building already exists.'
            );

            return response()->json($response);
        }else {
            $userBuilding = new UserBuilding();

            $userBuilding->user_id = $userId;
            $userBuilding->building_id = $buildingId;
            $userBuilding->level = $buildingLevel;

            $userBuilding->save();

            $response = array(
                'status' => 200,
                'message' => 'Building added with success!',
                'building' => $userBuilding
            );

            return response()->json($response);
        }
    }
}