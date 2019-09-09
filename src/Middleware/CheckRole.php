<?php

namespace Lvmod\ControlPanel\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Lvmod\ControlPanel\Repositories\UserRepository;

class CheckRole {

    protected $user;
    
    public function __construct(UserRepository $user) {
        $this->user = $user;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, ...$roles) {
        if (!Auth::check()) {
            return redirect('/login');
        }

        $userRoles = $request->user()->roles;

        $allow = false;
        foreach ($roles as $role) {
            foreach ($userRoles as $userRole) {
                if($userRole->name == $role) {
                    $allow = true;
                    break;
                }
            }
            
            if($allow) {
                break;
            }
        }
        
        if (!$allow) {
            return redirect('/login');
        }

        return $next($request);
    }

}
