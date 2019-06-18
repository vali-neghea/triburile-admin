<?php


namespace App\Interfaces;


interface VillageBuildingInterface
{
    public function store($villageId, $buildingId, $level);

    public function serachForBuilding($villageId, $buildingId);
}
