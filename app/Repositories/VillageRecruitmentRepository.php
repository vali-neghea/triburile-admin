<?php


namespace App\Repositories;


use App\Interfaces\VillageRecruitmentInterface;
use App\VillageRecruitment;

class VillageRecruitmentRepository implements VillageRecruitmentInterface
{
    /**
     * @param $villageId
     * @param $troopId
     * @param $troopNumber
     * @param $timePerTroop
     * @param $finishDate
     * @return mixed
     */
    public function store($villageId, $troopId, $troopNumber, $timePerTroop, $finishDate)
    {
        $villageRecruitment = new VillageRecruitment();

        $villageRecruitment->village_id = $villageId;
        $villageRecruitment->troop_id = $troopId;
        $villageRecruitment->number_of_troops = $troopNumber;
        $villageRecruitment->time_per_troop = $timePerTroop;
        $villageRecruitment->finish_date = $finishDate;

        $villageRecruitment->save();

        return $villageRecruitment;
    }

    /**
     * @param $recruitmentId
     * @param $amount
     * @return mixed
     */
    public function update($recruitment, $amount)
    {
        $recruitment->number_of_troops -= $amount;

        $recruitment->save();
    }


}
