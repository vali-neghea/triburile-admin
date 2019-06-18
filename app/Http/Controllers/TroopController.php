<?php
/**
 * Created by PhpStorm.
 * User: Andy
 * Date: 5/24/2019
 * Time: 1:05 PM
 */

namespace App\Http\Controllers;


use App\Helpers\ResponseHelper;
use App\Interfaces\VillageRecruitmentInterface;
use App\Services\UpdateResourceService;
use App\Models\Troop;
use App\Models\Village;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TroopController extends Controller
{
    protected $updateResourceService;
    protected $villageRecruitmentInterface;
    /**
     * TroopController constructor.
     */
    public function __construct(UpdateResourceService $updateResourceService, VillageRecruitmentInterface $villageRecruitmentInterface)
    {
        $this->updateResourceService = $updateResourceService;
        $this->villageRecruitmentInterface = $villageRecruitmentInterface;
    }

    public function store(Request $request) {
        $troopName = $request->name;
        $troopRecruitingTime = $request->recruiting_time;

        $similarTroop = Troop::where('name','like',$troopName)->get();

        if(count($similarTroop) > 0){

            return ResponseHelper::responseJson(200,1,'A troop already exists with this name or similar',$similarTroop);
        }else {
            $troop = new Troop();

            $troop->name = $troopName;
            $troop->recruiting_time = $troopRecruitingTime;

            $troop->save();

            return ResponseHelper::responseJson(200,1,'Troop created with success',$troop);
        }
    }

    public function recruit(Request $request) {
        $village = Village::find($request->village_id);
        $troop = Troop::find($request->troop_id);
        $troopDetails = $troop->levels->where('level',1)->first();

        $resources = array(
            'clay_required' => $troopDetails->clay_required * $request->troop_number,
            'wood_required' => $troopDetails->wood_required * $request->troop_number,
            'metal_required' => $troopDetails->metal_required * $request->troop_number
        );


        if($resources['clay_required'] <= $village->clay && $resources['wood_required'] <= $village->wood && $resources['metal_required'] <= $village->metal) {
            $secondsToFinish = $troopDetails->recruiting_duration * $request->troop_number;
            $lastRecruitment = $village->recruitments->last();

            if($lastRecruitment || count($lastRecruitment) > 0) {
                $finishDate = Carbon::parse($lastRecruitment->finish_date)->addSeconds($secondsToFinish);
            }else {
                $finishDate = Carbon::now()->addSeconds($secondsToFinish);
            }

            $villageRecruitment = $this->villageRecruitmentInterface->store($village->id,$request->troop_id,$request->troop_number,$troopDetails->recruiting_duration,$finishDate);

            $this->updateResourceService->takeOffResources($village,(object) $resources);

            return ResponseHelper::responseJson(200,1,"Your troops are on the way.",$villageRecruitment);
        }else {
            return ResponseHelper::responseJson(200,0,"You don't have enough resources",'');
        }
    }
}
