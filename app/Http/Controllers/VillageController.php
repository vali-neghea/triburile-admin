<?php


namespace App\Http\Controllers;


use App\Village;

class VillageController extends Controller
{
    public function index() {
        $villages = Village::all();

        if ($villages) {
         $response = [
             'success' => 1,
             'status' => 200,
             'villages' => $villages
         ];

         return response()->json($response);
        }
    }

    public function getVillageById($id) {
        $village = Village::find($id);

        $response = array(
            'success' => 1,
            'status' => 200,
            'village' => $village
        );

        return response()->json($response);
    }
}