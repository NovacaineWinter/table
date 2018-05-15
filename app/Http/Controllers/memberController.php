<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class memberController extends Controller
{
    public function search(Request $request){

        if($request->has('target')){
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

                return $data;
        		/*return view('terminal.modal.memberSearchResults')->with('data',$data);*/
        	}else{
        		$users = \App\User::all()->sortByDesc('created_at');


        		if($request->has('pagination_stop')){
        			$users = $users->take(10);
        		}else{
        			$users = $users->take(10);
        		}
        			$data['target']=\App\table::find($request->get('target'));
        			$data['users'] = $users;

                  return $data;  
        		/*return view('terminal.modal.memberSearchResults')->with('data',$data);*/
        	}
        }else{
            return 'Cannot process request - table info not provided';
        }

    }



    public function all() {
        return \App\User::all();
    }


    public function enlargedProfilePic(Request $request){
        if($request->has('target')){
            $user = \App\User::find($request->get('target'));
            return view('terminal.modal.enlargeUserProfilePic')->with('user',$user);
        }else{    
            return 'Oops - Could not find member';
        }
    }



    public function addressLookup($postcodeForLookup){


        if($postcodeForLookup!=''){

            $url='https://api.getAddress.io/find/'.$postcodeForLookup.'?api-key=rvBtpEH-nUaFB-VJjC51PQ12935';

            //  Initiate curl
            $ch = \curl_init();

            // Disable SSL verification
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

            // Will return the response, if false it print the response
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);


            // Set the url
            curl_setopt($ch, CURLOPT_URL,$url);
            // Execute
            $result=curl_exec($ch);
            // Closing
            curl_close($ch);
            
            return $result;

        }else{
            $toReturn['success'] = false;
            $toReturn['message'] = 'Did not receive postcode to lookup';
        }
    }

}
