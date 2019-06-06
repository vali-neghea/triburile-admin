<?php
/**
 * Created by PhpStorm.
 * User: Andy
 * Date: 5/24/2019
 * Time: 1:05 PM
 */

namespace App\Http\Controllers;


use App\Helpers\ResponseHelper;
use App\Troop;
use Illuminate\Http\Request;

class TroopController extends Controller
{
    public function store(Request $request) {
        $troopName = $request->name;
        $troopRecruitingTime = $request->recruiting_time;

        $similarTroop = Troop::where('name','like',$troopName)->get();

        if(count($similarTroop) > 0){

            return ResponseHelper::responseJson(200,1,'A troop already exists with this name or similar',$similarTroop);
        }else {
            $troop = new Troop();

            $troop->name = $troopName;
            $troop->recruiting_time = $troopRecruitingTime;

            $troop->save();

            return ResponseHelper::responseJson(200,1,'Troop created with success',$troop);
        }
    }
}
