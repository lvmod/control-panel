<?php

namespace Lvmod\ControlPanel\Controllers;

use Lvmod\ControlPanel\Repositories\UserRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    /**
     * @var UserRepository
     */
    protected $user;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserRepository $user)
    {
        $this->user = $user;
    }

    public function list(Request $request)
    {
        return $this->user->find();
    }

}
