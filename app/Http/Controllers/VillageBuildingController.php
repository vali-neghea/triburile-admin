<?php
/**
 * Created by PhpStorm.
 * User: Andy
 * Date: 5/24/2019
 * Time: 1:05 PM
 */

namespace App\Http\Controllers;


use App\Helpers\ResponseHelper;
use App\Models\VillageBuilding;
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

            return ResponseHelper::responseJson(200,0,'This building already exists','');
        }else {
            $villageBuilding = new VillageBuilding();

            $villageBuilding->village_id = $villageId;
            $villageBuilding->building_id = $buildingId;
            $villageBuilding->level = $buildingLevel;

            $villageBuilding->save();

            return ResponseHelper::responseJson(200,1,'Building added with success',$villageBuilding);
        }
    }

    public function upgrade($userId,$buildingId){

    }
}
