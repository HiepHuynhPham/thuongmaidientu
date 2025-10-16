<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\Request;
class DashboardController extends Controller{
    private $userService;

    public function __construct(UserService $userService){
        $this->userService = $userService;
    }

    public function viewDashboard(){
        return view("admin.dashboard.show");
    }
}