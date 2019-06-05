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
use App\User;
use Illuminate\Http\Request;

class BuildingController extends Controller
{
    public function store(Request $request) {
        $buildingName = $request->name;
        $buildingTimeToBuild = $request->time_to_build;
        $buildingMaxLvl = $request->max_level;

        $similarBuilding = Building::where('name','like',$buildingName)->get();

        if(count($similarBuilding) > 0){
            $response = array(
                'status' => 200,
                'message' => 'A building already exists with this name or similar',
                'troop' => $similarBuilding
            );

            return response()->json($response);
        }else {
            $building = new Building();

            $building->name = $buildingName;
            $building->max_level = $buildingMaxLvl;
            $building->time_to_build = $buildingTimeToBuild;

            $building->save();

            $response = array(
                'status' => 200,
                'message' => 'Building created with success',
                'troop' => $building
            );

            return response()->json($response);
        }
    }

    public function getBuildings($userId) {
        $user = User::find($userId);
        $buildings = array();

        foreach ($user->buildings as $key => $building) {
            $buildings[$key] = [
                'name' => $building->name,
                'max_level' => $building->max_level,
                'time_to_build' => $building->time_to_build,
                'level' => $building->pivot->level
            ];
        }

        $response = array(
            'status'=> 200,
            'success' => 1,
            'message' => 'List of buildings',
            'buildings' => $buildings
        );

        return response()->json($response);
    }

    public function upgrade($userId,$buildingId) {
        dump($userId);
        dump($buildingId);
        die('On file '. __FILE__ . 'at line ' . __LINE__);
    }
}