<?php


namespace App\Http\Controllers;


use App\Helpers\ResponseHelper;
use App\Models\Village;
use Illuminate\Http\Request;

class VillageController extends Controller
{
    public function index() {
        $villages = Village::all();

        if ($villages) {
         return ResponseHelper::responseJson(200,1,'List of villages',$villages);
        }
    }

    public function getBuildings(Request $request) {
        $village = Village::find($request->village_id);
        $buildings = array();

        foreach ($village->buildings as $key => $building) {
            $buildings[$key] = [
                'name' => $building->name,
                'max_level' => $building->max_level,
                'level' => $building->pivot->level
            ];
        }

        return ResponseHelper::responseJson(200,1,'List of buildings',$buildings);
    }

    public function getVillageById($userId, $villageId) {
        $village = Village::find($villageId);
        $troops = array();
        
        foreach ($village->villageTroops as $key => $villageTroop) {
            $troops[$key]['name'] = $villageTroop->troop->name;
            $troops[$key]['level'] = $villageTroop->level;
        }
        $village['troops'] = $troops;
        
        return ResponseHelper::responseJson(200,1,'Details about village',$village);
    }
}
