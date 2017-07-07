<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RewardController extends Controller
{
    public function __construct()
    {
        $this->middleware('reward');
    }

    //
    public function index() {
        return view('auth.reward');
    }


    public function getReward() {
        return 'aaa';
    }
}
