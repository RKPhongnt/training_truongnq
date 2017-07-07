<?php

/* 
 *Trait for login with username
 */
namespace App\Traits;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


trait MyAuthenticatesUsers
{
    use AuthenticatesUsers {
        AuthenticatesUsers::username as parentUsername;
        AuthenticatesUsers::sendLoginResponse as parentSendLoginResponse;
    }
    
    /*
     * override from parent, return username instend of email
     */
    public function username() {
        return 'username';
    }
    
    public function sendLoginResponse(Request $request) {
        $request->session()->regenerate();

        $this->clearLoginAttempts($request);

        return $this->authenticated($request, $this->guard()->user())
                ?: redirect()->intended($this->redirectPath())
                ?: redirect()->back()->withInput($request->only('username', 'remember'));
    }

}

