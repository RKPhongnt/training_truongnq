<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\User;

class ChangePasswordController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function changePassword(Request $request, $id) {
        $this->validatePassword($request);

        try {
            $user = Auth::user();
            if ($id != $user->id) {
                return view('admin.not-found');
            }
            $user->password = bcrypt($request->input('password'));
            $user->is_active = 1;
            $user->save();
            Auth::logout();
            return redirect('login');
        }catch (ModelNotFoundException $exception) {
            return view('admin.not-found');
        }

    }

    /**
     * validate password
     * @param Request $request
     */

    protected function validatePassword(Request $request) {
        $this->validate($request, [
            'password' => 'required|string|min:6|confirmed'
        ]);
    }

    /**
     * show change password form
     * @return $this
     */
    public function showChangePasswordForm() {
        $user = Auth::user();
        return view('change-password')->with(compact('user'));
    }
}
