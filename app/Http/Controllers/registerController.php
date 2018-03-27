<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class registerController extends Controller
{
    public function signUp(Request $request){

    	if($request->has('target')){
    		if($request->hasFile('input_img')){
    			return 'hello!!';
    		}
    	}else{
    		return view('register.signupForm');
    	}
    }

    public function receive(Request $request){
    	if($request->hasFile('input_img') && $request->has('target')){
    		return App\User::find($request->get('target'))->updateProfilePic($request->file('input_img'));
	    }
    }
}
			