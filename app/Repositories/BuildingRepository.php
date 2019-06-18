<?php


namespace App\Repositories;


use App\Interfaces\BuildingInterface;
use App\Models\VillageBuildings;

class BuildingRepository implements BuildingInterface
{
    /**
     * @param $villageId
     * @param $buildingId
     * @return mixed
     */
    public function addDefaultBuildings($villageId, $buildingId)
    {
        $villageBuilding = new VillageBuildings();

        $villageBuilding->village_id = $villageId;
        $villageBuilding->building_id = $buildingId;
        $villageBuilding->level = 1;

        $villageBuilding->save();
    }

}
