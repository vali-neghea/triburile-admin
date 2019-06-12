<?php


namespace App\Http\Controllers;


use App\Helpers\ResponseHelper;
use App\Village;
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

        return ResponseHelper::responseJson(200,1,'Details about village',$village);
    }
}
