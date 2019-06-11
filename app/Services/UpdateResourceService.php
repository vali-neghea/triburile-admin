<?php


namespace App\Services;


use App\Building;
use App\Village;
use App\VillageProduction;
use Illuminate\Support\Facades\DB;

class UpdateResourceService
{
    public function updateVillageResource($villages,$difference) {
        foreach ($villages as $village) {
            //ce se produce pe oras
            $productions = VillageProduction::where('village_id',$village->id)->get();

            foreach ($productions as $production) {
                $buildingName = Building::where('id',$production->building_id)->pluck('name')->first();
                $resourceName = strtolower (explode(" ",$buildingName)[0]);

                $newResource = $village->$resourceName + ($difference * $production->production_per_hour);

                Village::where('id',$village->id)->update([$resourceName => $newResource]);
            }
        }

        return true;
    }

    public function takeOffResources($village, $resources){
        $village->clay -= $resources->clay_required;
        $village->wood -= $resources->wood_required;
        $village->metal -= $resources->metal_required;

        $village->save();

        return true;
    }

    public function updateVillageProduction($villageId,$buildingId,$level) {
        $villageProduction = VillageProduction::where('village_id',$villageId)->where('building_id',$buildingId)->first();
        $building = Building::where('id',$buildingId)->first();

        $buildingDetails = $building->levels->where('level',$level)->first();
        $villageProduction->production_per_hour = $buildingDetails->bonus;
        $villageProduction->save();
        
        return true;

    }
}
