<?php


namespace App\Repositories;


use App\Interfaces\BuildingInterface;
use App\VillageBuilding;

class BuildingRepository implements BuildingInterface
{
    /**
     * @param $villageId
     * @param $buildingId
     * @return mixed
     */
    public function addDefaultBuildings($villageId, $buildingId)
    {
        $villageBuilding = new VillageBuilding();

        $villageBuilding->village_id = $villageId;
        $villageBuilding->building_id = $buildingId;
        $villageBuilding->level = 1;

        $villageBuilding->save();
    }

}
