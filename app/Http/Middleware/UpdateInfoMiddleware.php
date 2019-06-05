<?php


namespace App\Http\Middleware;

use App\Services\UserService;
use App\User;
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
        if ($request->path() == 'login'){
            $userId = User::where('email',$request->email)->first()->id;
        }else {
            $userId = $request->user_id;
        }
        
        return $next($request);
    }
}
