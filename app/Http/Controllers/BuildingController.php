<?php
/**
 * Created by PhpStorm.
 * User: Andy
 * Date: 5/24/2019
 * Time: 1:05 PM
 */

namespace App\Http\Controllers;


use App\Building;
use App\Helpers\ResponseHelper;
use App\Troop;
use App\User;
use Illuminate\Http\Request;

class BuildingController extends Controller
{
    public function store(Request $request) {
        $buildingName = $request->name;
        $buildingMaxLvl = $request->max_level;

        $similarBuilding = Building::where('name','like',$buildingName)->get();

        if(count($similarBuilding) > 0){

            return ResponseHelper::responseJson(1,200,'A building already exists with this name or similar',$similarBuilding);
        }else {
            $building = new Building();

            $building->name = $buildingName;
            $building->max_level = $buildingMaxLvl;

            $building->save();

            return ResponseHelper::responseJson(200,1,'Building created with success',$building);
        }
    }

    public function getBuildings($userId) {
        $user = User::find($userId);
        $buildings = array();

        foreach ($user->buildings as $key => $building) {
            $buildings[$key] = [
                'name' => $building->name,
                'max_level' => $building->max_level,
                'level' => $building->pivot->level
            ];
        }

        return ResponseHelper::responseJson(200,1,'List of buildings',$buildings);
    }

    public function upgrade($userId,$buildingId) {
        dump($userId);
        dump($buildingId);
        die('On file '. __FILE__ . 'at line ' . __LINE__);
    }
}
