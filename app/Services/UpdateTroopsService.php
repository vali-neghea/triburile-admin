<?php


namespace App\Services;


use App\Interfaces\VillageRecruitmentInterface;
use App\Interfaces\VillageTroopInterface;
use Carbon\Carbon;

class UpdateTroopsService
{
    private $villageTroopRepository;
    private $villageRecruitmentRepository;
    /**
     * UpdateTroopsService constructor.
     */
    public function __construct(VillageTroopInterface $villageTroopRepository, VillageRecruitmentInterface $villageRecruitmentRepository)
    {
        $this->villageTroopRepository = $villageTroopRepository;
        $this->villageRecruitmentRepository = $villageRecruitmentRepository;
    }


    public function updateVillageTroops($userVillages) {
        
        foreach ($userVillages as $village) {
            if(count($village->recruitments) > 0) {
                foreach ($village->recruitments as $recruitment) {
                    //Check if the recruitment is totally finished or not.Exemple: If 30/30 fighters have been recruited or if only 15/30 have been recruited
                    if(Carbon::parse($recruitment->finish_date) < Carbon::now()){
                        $troopsRecruited = $recruitment->number_of_troops;

                        $recruitment->delete();
                    }else {
                        $totalSeconds = $recruitment->number_of_troops * $recruitment->time_per_troop;
                        $remainingSeconds = Carbon::now()->diffInSeconds(Carbon::parse($recruitment->finish_date));
                        $difference = $totalSeconds - $remainingSeconds;
                        $troopsRecruited = floor($difference / $recruitment->time_per_troop);

                        $this->villageRecruitmentRepository->update($recruitment,$troopsRecruited);
                    }

                    //Check if the village already have at least 1 unit of a type.Yes: update the amount number, Else: create new row
                    if($village->troops) {
                        $villageTroops = $village->troops->where('troop_id',$recruitment->troop_id)->first();
                    }else {
                        $villageTroops = null;
                    }

                    if($villageTroops) {
                        $this->villageTroopRepository->update($villageTroops,$troopsRecruited);
                    }else {
                        $this->villageTroopRepository->store($village->id,$recruitment->troop_id,$troopsRecruited);
                    }
                }
            }
        }

        return true;
    }
}
