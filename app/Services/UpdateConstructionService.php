<?php


namespace App\Services;


use App\Village;
use App\VillageBuilding;
use App\VillageConstruction;
use Carbon\Carbon;

class UpdateConstructionService
{
    public function updateConstructions($villages) {
        foreach ($villages as $village) {
            $constructions = VillageConstruction::where('village_id',$village->id)->get();

            foreach ($constructions as $construction) {
                if(Carbon::now() > $construction->finish_date) {
                    $villageBuilding = VillageBuilding::where('village_id',$village->id)->where('building_id',$construction->building_id)->first();
                    $villageBuilding->level += 1;
                    $villageBuilding->save();

                    $construction->delete();
                }
            }
        }
    }
}
