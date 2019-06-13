<?php
/**
 * Created by PhpStorm.
 * User: Andy
 * Date: 5/24/2019
 * Time: 1:05 PM
 */

namespace App\Http\Controllers;


use App\Building;
use App\Helpers\ResponseHelper;
use App\Interfaces\VillageConstructionInterface;
use App\Services\UpdateResourceService;
use App\User;
use App\UserVillage;
use App\Village;
use App\VillageBuilding;
use App\VillageConstruction;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BuildingController extends Controller
{
    protected $resourcesService;
    protected $villageConstructionInterface;

    /**
     * BuildingController constructor.
     */
    public function __construct(UpdateResourceService $resourceService, VillageConstructionInterface $villageConstructionInterface)
    {
        $this->resourcesService = $resourceService;
        $this->villageConstructionInterface = $villageConstructionInterface;
    }

    public function store(Request $request) {
        $buildingName = $request->name;
        $buildingMaxLvl = $request->max_level;

        $similarBuilding = Building::where('name','like',$buildingName)->get();

        if(count($similarBuilding) > 0){

            return ResponseHelper::responseJson(1,200,'A building already exists with this name or similar',$similarBuilding);
        }else {
            $building = new Building();

            $building->name = $buildingName;
            $building->max_level = $buildingMaxLvl;

            $building->save();

            return ResponseHelper::responseJson(200,1,'Building created with success',$building);
        }
    }

    public function getBuildings(Request $request) {
        $village = Village::find($request->village_id);
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

    public function upgrade(Request $request) {
        $user = User::where('api_token',$request->user_token)->first();
        $userVillage = UserVillage::where('user_id',$user->id)->where('village_id',$request->village_id)->first();

        if(!$userVillage) {
            return ResponseHelper::responseJson(404,0,'This village is not yours','');
        }

        $buildingVillage = VillageBuilding::where('village_id',$request->village_id)->where('building_id',$request->building_id)->first();

        if(!$buildingVillage) {
            return ResponseHelper::responseJson(404,0,"You don't have this building in this village",'');
        }

        $villageConstructions = VillageConstruction::where('village_id',$request->village_id)->where('building_id',$request->building_id)->first();

        if($villageConstructions) {
            return ResponseHelper::responseJson(404,0,"This building is already in construction.",'');
        }

        $village = Village::where('id',$request->village_id)->first();
        
        $building = Building::where('id',$request->building_id)->first();
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
