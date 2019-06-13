<?php


namespace App\Interfaces;


interface VillageRecruitmentInterface
{
    public function store($villageId,$troopId,$troopNumber,$timePerTroop,$finishDate);

    public function update($recruitmentId,$amount);
}
