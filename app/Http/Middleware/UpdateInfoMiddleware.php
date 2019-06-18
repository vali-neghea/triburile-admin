<?php


namespace App\Http\Middleware;

use App\Helpers\ResponseHelper;
use App\Services\UpdateConstructionService;
use App\Services\UpdateResourceService;
use App\Services\UpdateTroopsService;
use App\Services\UserService;
use App\Models\User;
use Carbon\Carbon;
use Closure;

/**
 * Class UpdateInfoMiddleware
 * @package App\Http\Middleware
 */
class UpdateInfoMiddleware
{
    protected $userService;
    protected $updateResourceService;
    protected $updateConstructionService;
    protected $updateTroopService;

    /**
     * UpdateInfoMiddleware constructor.
     * @param $userService
     */
    public function __construct(UserService $userService, UpdateResourceService $updateResourceService, UpdateConstructionService $updateConstructionService, UpdateTroopsService $updateTroopsService)
    {
        $this->userService = $userService;
        $this->updateResourceService = $updateResourceService;
        $this->updateConstructionService = $updateConstructionService;
        $this->updateTroopService = $updateTroopsService;
    }


    /**
     * @param $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        $userToken = $request->headers->get('Authorization');
        
        $user = User::where('api_token',$userToken)->first();
        if(!$user) {
            return ResponseHelper::responseJson('404',0,'You are not logged in','');
        }
        $userVillages = $user->villages;

        $now = Carbon::now();
        $lastRequest = Carbon::parse($user->last_request);
        $difference = $now->diffInHours($lastRequest);

        if($now->diffInSeconds($lastRequest) >= 40) {
            $this->updateResourceService->updateVillageResource($userVillages,$difference);
        }
        $this->updateConstructionService->updateConstructions($userVillages);
        $this->updateTroopService->updateVillageTroops($userVillages);


        $this->userService->updateLastRequest($userToken);

        return $next($request);
    }
}
