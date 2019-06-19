<?php


namespace App\Interfaces;


interface VillageTroopInterface
{
    public function store($villageId,$troopId,$amount,$ownerShip);

    public function update($villageTroops,$amount);
}
