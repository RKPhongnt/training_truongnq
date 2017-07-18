<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Mail;

class AdminController extends Controller
{
    
    public function __construct() {
        $this->middleware('admin');
    }

    //
    public function index() {
        return view('admin.dashboard');
    }

    /*
     * create new user
     */

    public function newUser(Request $request) {
        //validate data
        $this->validateNewUser($request);
        //create new user
            $user = $this->createUser($request->all());


        $this->notifyAfterCreateUser($request->all());

        echo $user;
    }

    /*
     * create new user with model
     */
    protected function createUser(array $data) {
        return User::create([
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'is_admin' => $data['is_admin'],
            'is_active' => '0',
        ]);
    }

    /*
     * show new user form
     */
    public function showNewUserForm() {
        return view('admin.new-user');
    }

    /*
     *validate user information before create
     */

    protected function validateNewUser(Request $request) {
        $this->validate($request, [
            'username' => 'required|string|min:6|unique:users',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'is_admin' => 'required'
        ], [
            'username.required' =>'username required',
            'username.min'    => 'username\'s length must >= 6',
            'username.unique' => 'username exsisted!',
            'email.required' =>'email required',
            'email.email' =>'you must fill email',
            'password.required' => 'password required',
            'password.min' => 'password\'s length must >= 6',
            'password.confirmed' => 'please type same password',
        ]);
    }

    protected function notifyAfterCreateUser(array $data) {
        Mail::send('emails.new-user', $data, function($message) use($data){
            $message->to($data['email'])->subject('Welcome!');
        });
    }
}
