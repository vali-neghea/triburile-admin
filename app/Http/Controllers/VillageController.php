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

    public function getVillageById(Request $request) {
        $village = Village::find($request->village_id);
        $troops = array();
        
        foreach ($village->villageTroops as $key => $villageTroop) {
            $troops[$key]['name'] = $villageTroop->troop->name;
            $troops[$key]['level'] = $villageTroop->level;
        }
        $village['troops'] = $troops;
        
        return ResponseHelper::responseJson(200,1,'Details about village',$village);
    }
}
