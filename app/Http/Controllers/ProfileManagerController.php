<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileManagerController extends Controller
{
    public function __construct()
    {
        $this->middleware('login');
    }

    public function showProfile() {
        $user = Auth::user();
        return view('user.profile')->with(compact('user'));
    }

    public function update(Request $request) {
        $user = Auth::user();
        if ($request->input('password')) {
            $user->password = bcrypt($request->input('password'));
        }
        $user->save();

        return redirect()->back()->with('message', 'Update success');
    }
}
