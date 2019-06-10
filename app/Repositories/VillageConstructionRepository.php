<?php


namespace App\Repositories;


use App\Interfaces\VillageConstructionInterface;
use App\VillageConstruction;

class VillageConstructionRepository implements VillageConstructionInterface
{
    /**
     * @param $params
     * @return mixed
     */
    public function store($villageId, $buildingId, $levelUpgrade, $finishDate)
    {
        $villageConstruction = new VillageConstruction();

        $villageConstruction->village_id = $villageId;
        $villageConstruction->building_id = $buildingId;
        $villageConstruction->level_upgrade = $levelUpgrade;
        $villageConstruction->finish_date = $finishDate;

        $villageConstruction->save();

        return $villageConstruction;
    }

}
