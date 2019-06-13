<?php


namespace App\Interfaces;


interface VillageTroopInterface
{
    public function store($villageId,$troopId,$amount);

    public function update($villageTroops,$amount);
}
