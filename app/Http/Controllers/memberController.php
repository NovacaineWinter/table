<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class memberController extends Controller
{
    public function search(Request $request){
    	if($request->has('term') && $request->get('term')!='' && $request->get('term')!=null){

    		$words = explode(' ',$request->get('term'));

    		if(count($words)>1){

				$users = \App\User::where('lname','LIKE','%'.$words[1].'%')
				->where('fname','LIKE','%'.$words[0].'%')
				->get()
				->sortByDesc('created_at');
				
    		}else{
				$lname = \App\User::where('lname','LIKE','%'.$words[0].'%')				
				->get()
				->sortByDesc('created_at');

				$fname = \App\User::where('fname','LIKE','%'.$words[0].'%')				
				->get()
				->sortByDesc('created_at');

				$users = $lname->merge($fname);
				
    		} 

    		if($request->has('pagination_stop')){
    			$users = $users->take(2);
    		}else{
    			$users = $users->take(2);
    		}

    		$data['target']=\App\table::find($request->get('target'));
    		$data['users'] = $users;

    		return view('terminal.modal.memberSearchResults')->with('data',$data);
    	}else{
    		$users = \App\User::all()->sortByDesc('created_at');


    		if($request->has('pagination_stop')){
    			$users = $users->take(10);
    		}else{
    			$users = $users->take(10);
    		}
    			$data['target']=\App\table::find($request->get('target'));
    			$data['users'] = $members;
    		return view('terminal.modal.memberSearchResults')->with('data',$data);
    	}
    }
}
