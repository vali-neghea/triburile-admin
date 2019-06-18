<?php


namespace App\Repositories;


use App\Interfaces\VillageBuildingInterface;
use App\Models\VillageBuildings;

class VillageBuildingRepository implements VillageBuildingInterface
{
    /**
     * @param $villageId
     * @param $buildingId
     * @param $level
     * @return mixed
     */
    public function store($villageId, $buildingId, $level)
    {
        $villageBuilding = new VillageBuildings();

        $villageBuilding->village_id = $villageId;
        $villageBuilding->building_id = $buildingId;
        $villageBuilding->level = $level;

        $villageBuilding->save();

        return $villageBuilding;
    }

    /**
     * @param $villageId
     * @param $buildingId
     * @return mixed
     */
    public function serachForBuilding($villageId, $buildingId)
    {
        $villageBuilding = VillageBuildings::where('village_id','=',$villageId)
            ->where('building_id','=',$buildingId)
            ->get();

        return $villageBuilding;
    }


}
