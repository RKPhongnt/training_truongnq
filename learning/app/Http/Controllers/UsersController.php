<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UsersController extends Controller
{
    public function index() {
        $user = User::all();
        return $user;
    }

    public function show($id) {
        return $id;
    }

    public function create() {
        return view('users/create');
    }
}
