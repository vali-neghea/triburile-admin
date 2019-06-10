<?php


namespace App\Interfaces;


interface VillageConstructionInterface
{
    public function store($villageId, $buildingId, $levelUpgrade, $finishDate);
}
