<?php


namespace App\Repositories;


use App\Interfaces\VillageTroopInterface;
use App\Models\VillageTroops;

class VillageTroopRepository implements VillageTroopInterface
{
    /**
     * @param $villageTroops
     * @param $amount
     * @return mixed
     */
    public function update($villageTroops, $amount)
    {
        $villageTroops->amount += $amount;

        $villageTroops->save();
    }

    /**
     * @param $villageId
     * @param $troopId
     * @param $amount
     * @return mixed
     */
    public function store($villageId, $troopId, $amount)
    {
        $villageTroops = new VillageTroops();

        $villageTroops->village_id = $villageId;
        $villageTroops->troop_id = $troopId;
        $villageTroops->amount = $amount;

        $villageTroops->save();
    }

}
