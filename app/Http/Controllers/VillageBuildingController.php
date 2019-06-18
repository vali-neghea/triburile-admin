<?php
/**
 * Created by PhpStorm.
 * User: Andy
 * Date: 5/24/2019
 * Time: 1:05 PM
 */

namespace App\Http\Controllers;


use App\Interfaces\VillageConstructionInterface;
use App\Models\Building;
use App\Models\BuildingLevels;
use App\Helpers\ResponseHelper;
use App\Interfaces\VillageBuildingInterface;
use App\Models\User;
use App\Models\UserVillage;
use App\Models\Village;
use App\Models\VillageBuildings;
use App\Models\VillageConstruction;
use App\Services\UpdateResourceService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class VillageBuildingController extends Controller
{
    private $villageBuildingInterface;
    private $resourcesService;
    private $villageConstructionInterface;
    /**
     * VillageBuildingController constructor.
     */
    public function __construct(VillageBuildingInterface $villageBuildingInterface,UpdateResourceService $resourceService, VillageConstructionInterface $villageConstructionInterface)
    {
        $this->villageBuildingInterface = $villageBuildingInterface;
        $this->resourcesService = $resourceService;
        $this->villageConstructionInterface = $villageConstructionInterface;
    }


    public function store(Request $request) {
        $villageId = $request->village_id;
        $buildingId = $request->building_id;
        $buildingLevel = $request->level;

        $sameBuilding = $this->villageBuildingInterface->serachForBuilding($villageId,$buildingId);

        if(count($sameBuilding) > 0) {

            return ResponseHelper::responseJson(200,0,'This building already exists','');
        }else {

            $villageBuilding = $this->villageBuildingInterface->store($villageId,$buildingId,$buildingLevel);

            return ResponseHelper::responseJson(200,1,'Building added with success',$villageBuilding);
        }
    }

    public function getBuildings($villageId) {
        $village = Village::find($villageId);
        $buildings = array();

        foreach ($village->buildings as $key => $building) {
            $buildings[$key] = [
                'name' => $building->name,
                'max_level' => $building->max_level,
                'level' => $building->pivot->level
            ];
        }
        return ResponseHelper::responseJson(200,1,'List of buildings',$buildings);
    }

    public function getBuildingDetails($villageId, $buildingId){
        $village = Village::find($villageId);
        $building = $village->buildings->find($buildingId);
        $levelDetails = BuildingLevels::where('building_id',$buildingId)->where('level',$building->pivot->level)->first();

        $response = array(
            'building_id' => $building->id,
            'building_name' => $building->name,
            'building_level' => $building->pivot->level,
            'production' => $levelDetails->bonus,
            'upgrade_clay_required' => $levelDetails->clay_required,
            'upgrade_wood_required' => $levelDetails->wood_required,
            'upgrade_metal_required' => $levelDetails->metal_required,
        );

        return ResponseHelper::responseJson(200,1,$response['building_name'].' details',$response);
    }

    public function upgrade($villageId, $buildingId) {
        //TODO: move this to middleware
//        $user = User::where('api_token',$request->headers->get('Authorization'))->first();
//        $userVillage = UserVillage::where('user_id',$user->id)->where('village_id',$request->village_id)->first();
//
//        if(!$userVillage) {
//            return ResponseHelper::responseJson(404,0,'This village is not yours','');
//        }

        $buildingVillage = VillageBuildings::where('village_id',$villageId)->where('building_id',$buildingId)->first();

        if(!$buildingVillage) {
            return ResponseHelper::responseJson(404,0,"You don't have this building in this village",'');
        }

        $villageConstructions = VillageConstruction::where('village_id',$villageId)->where('building_id',$buildingId)->first();

        if($villageConstructions) {
            return ResponseHelper::responseJson(404,0,"This building is already in construction.",'');
        }

        $village = Village::where('id',$villageId)->first();

        $building = Building::where('id',$buildingId)->first();
        $buildingDetails = $building->levels->where('level',$buildingVillage->level+1)->first();

        if($village->wood >= $buildingDetails->wood_required && $village->clay >= $buildingDetails->clay_required && $village->metal >= $buildingDetails->metal_required) {
            $this->resourcesService->takeOffResources($village,$buildingDetails);

            $response = $this->villageConstructionInterface->store($village->id, $building->id, $buildingDetails->level, Carbon::now()->addSeconds($buildingDetails->upgrade_duration));

            return ResponseHelper::responseJson(200,1,"Your building is in construction.You'll get an email when it's done.Pwp dicky licky :*",$response);
        }else {
            return ResponseHelper::responseJson(404,0,"You don't have enough resources",'');
        }
    }
}
