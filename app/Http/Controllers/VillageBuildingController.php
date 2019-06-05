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
use App\VillageBuilding;
use Illuminate\Http\Request;

class VillageBuildingController extends Controller
{
    public function store(Request $request) {
        $villageId = $request->village_id;
        $buildingId = $request->building_id;
        $buildingLevel = $request->level;

        $sameBuilding = VillageBuilding::where('village_id','=',$villageId)
                                    ->where('building_id','=',$buildingId)
                                    ->get();

        if(count($sameBuilding) > 0) {
            $response = array(
                'status' => 200,
                'message' => 'This building already exists.'
            );

            return response()->json($response);
        }else {
            $villageBuilding = new VillageBuilding();

            $villageBuilding->village_id = $villageId;
            $villageBuilding->building_id = $buildingId;
            $villageBuilding->level = $buildingLevel;

            $villageBuilding->save();

            $response = array(
                'status' => 200,
                'message' => 'Building added with success!',
                'building' => $villageBuilding
            );

            return response()->json($response);
        }
    }

    public function upgrade($userId,$buildingId){

    }
}