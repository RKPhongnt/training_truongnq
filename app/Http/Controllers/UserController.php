<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    
    public function __construct() {
        $this->middleware('user');
    }
    
    public function index() {
        return view('user.dashboard');
    }




}
