<?php


namespace App\Http\Controllers;


use App\Helpers\ResponseHelper;
use App\Village;

class VillageController extends Controller
{
    public function index() {
        $villages = Village::all();

        if ($villages) {
         return ResponseHelper::responseJson(200,1,'List of villages',$villages);
        }
    }

    public function getVillageById($id) {
        $village = Village::find($id);

        return ResponseHelper::responseJson(200,1,'Details about 1 village',$village);
    }
}
