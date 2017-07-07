<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageControllers extends Controller
{
    //
    
    public function about() 
    {
    	$developer = [
            'Truong',
            'Linh',
            'Quy',
            'Lai',
        ];
        
        return view('about',compact('developer'));
    }
    

}
