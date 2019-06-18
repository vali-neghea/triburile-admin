<?php


namespace App\Services;


use App\Models\Building;
use App\Models\VillageBuildings;
use App\Models\VillageConstruction;
use Carbon\Carbon;

class UpdateConstructionService
{
    protected $updateResourceService;
    /**
     * UpdateConstructionService constructor.
     */
    public function __construct(UpdateResourceService $updateResourceService)
    {
        $this->updateResourceService = $updateResourceService;
    }

    public function updateConstructions($villages) {
        foreach ($villages as $village) {
            $constructions = VillageConstruction::where('village_id',$village->id)->get();

            foreach ($constructions as $construction) {
                if(Carbon::now() > $construction->finish_date) {
                    $villageBuilding = VillageBuildings::where('village_id',$village->id)->where('building_id',$construction->building_id)->first();
                    $building = Building::find($villageBuilding->building_id);

                    $villageBuilding->level = 4;
                    $villageBuilding->save();

                    if($building->production) {
                        $this->updateResourceService->updateVillageProduction($village->id, $building->id,$villageBuilding->level);
                    }

                    $construction->delete();
                }
            }
        }
    }
}
