<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */
 
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/admin';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    
    /**
     * Return route after login success
     * @return string
     */
    public function redirectTo() 
    {
        return $this->redirectTo;
    }
    
    /**
     * Login 
     * @param Request $request
     */
    public function login(Request $request) {
        // validate
        $this->validateLogin($request);
        
        //attempt login and redirect o user or Admin dashboard

        if(Auth::attempt(['username' => $request->username, 'password' => $request->password], $request->remember)) {
            $user = Auth::user();
            if ($user->is_admin == 1){
                 return redirect('admin');
            }
            return redirect('user');
        }
        
        return redirect()->back()->withInput($request->only('username', 'remember'));
    }
    
    /**
     * Validate form data
     * @param Request $request
     */
    private function validateLogin(Request $request) {
        $this->validate($request, [
            'username' => 'required|min:6|string',
            'password' => 'required|min:6|string'
            
            ]);
    }
    
    public function showLoginForm() {
       
        return view('auth.login');
    }
    
    public function logout() {
        Auth::logout();
        return redirect('login');
    }

   
}
