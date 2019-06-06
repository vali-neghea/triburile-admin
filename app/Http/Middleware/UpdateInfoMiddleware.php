<?php


namespace App\Http\Middleware;

use App\Services\UserService;
use App\User;
use Carbon\Carbon;
use Closure;
use phpDocumentor\Reflection\Element;

/**
 * Class UpdateInfoMiddleware
 * @package App\Http\Middleware
 */
class UpdateInfoMiddleware
{
    protected $userService;

    /**
     * UpdateInfoMiddleware constructor.
     * @param $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }


    /**
     * @param $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        $userToken = $request->user_token;
        
        $user = User::where('api_token',$userToken)->get()->first();

        $now = Carbon::now();
        $lastRequest = Carbon::parse($user->last_request);
        $difference = $now->diffInSeconds($lastRequest);

        $this->userService->updateLastRequest($userToken);

        return $next($request);
    }
}
