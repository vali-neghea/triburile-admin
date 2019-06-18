<?php


namespace App\Services;


use App\Interfaces\BuildingInterface;

class BuildingService
{
    private $buildingInterface;
    /**
     * BuildingService constructor.
     */
    public function __construct(BuildingInterface $buildingInterface)
    {
        $this->buildingInterface = $buildingInterface;
    }

    public function addDefaultBuildingsToVillage($villageId) {
        $defaultBuildings = [1,4,5,6];

        foreach ($defaultBuildings as $defaultBuilding) {
            $this->buildingInterface->addDefaultBuildings($villageId,$defaultBuilding);
        }

        return true;
    }
}
