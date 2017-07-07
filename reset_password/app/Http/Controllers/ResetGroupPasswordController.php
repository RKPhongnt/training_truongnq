<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Support\Arr;



class ResetGroupPasswordController extends Controller
{
    use SendsPasswordResetEmails;


    public function index() {
        return view('auth.passwords.group_email');
    }

    public function resetGroupPassword() {

        $mail = [];

        Arr::set($mail, 'email', 'truong.hn.1994@gmail.com');

        $this->broker()->sendResetLink( $mail);

        Arr::set($mail, 'email', 'truong.ict.1994@gmail.com');

        $this->broker()->sendResetLink( $mail);

        return 'done';
    }
}
