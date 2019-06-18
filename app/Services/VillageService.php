<?php


namespace App\Services;


use App\Models\UserVillage;
use App\Models\Village;

class VillageService
{
    public function store($user,$continendId, $x_coordinates, $y_coordinates){
        $village = new Village();

        $village->name = "Satul lui ".$user->name;
        $village->user_id = $user->id;
        $village->continent_id = $continendId;
        $village->x_coordinates = $x_coordinates;
        $village->y_coordinates = $y_coordinates;
        $village->wood = 300;
        $village->clay = 300;
        $village->metal = 300;
        $village->points = 60;

        $village->save();

        return $village->id;
    }

    public function addVillageToUser($userId, $villageId) {
        $userVillage = new UserVillage();

        $userVillage->user_id = $userId;
        $userVillage->village_id = $villageId;

        $saveStatus = $userVillage->save();

        if($saveStatus){
            return true;
        }else {
            return false;
        }
    }
}
