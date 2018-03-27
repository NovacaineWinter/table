<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\config;
use App\table;
use App\table_type;

class tableController extends Controller
{
    public function index(Request $request){

    	return view('terminalHome')->with('info',$this->generateHomepageData($request));

    }


    function generateHomepageData($request){
        $info =[];
        $info['request'] = $request;
        $info['table_types'] = table_type::all();

        $numTables = 0;


        foreach($info['table_types'] as $type){
            
            //check tables exist within this category           
            if($type->tables->count()>0){
                $numTables++; 
            }

            //go through each table and count the number of available tables
            $availTables = 0;
            foreach($type->tables as $tbl){
                if(!$tbl->is_occupied){
                    $availTables++;
                }
            }
            $info[$type->id]['available']=$availTables;
        }

        if($numTables>0){
            $info['colWidth'] = 99/$numTables;
            $info['rowWidth']    =$info['colWidth'] - 2;
        }else{
            $info['width'] = 100;
        } 
    
        return $info;
    }

    function ajax(Request $request){
    	$return=[];
    	$return['success']=true;
        $return['alert'] = false;

    	if($request->has('method')){
    		switch($request->get('method')){




/*=========*/
    			case 'tableSummary':
    				$target = \App\table::find($request->get('target'));
                    $users = \App\User::all();
                    $data=[];
                    $data['target']=$target;
                    $data['users']=$users;
                    $data['cancelLimit'] = \App\config::where('name','=','timeToCancelTable')->get()->first()->integer;
                    if($target->currentBooking->users){
                        $data['usersOnTable']=$target->currentBooking->users;
                    }else{
                        $data['usersOnTable']=false;
                    }
                    
    				$view = \View::make('terminal.tableSummaryModal',['data'=>$data]);
    				$return['data'] = $view->render();
    				return $return;
    				break;




/*=========*/
                case 'addUserToTable':
                    if($request->has('targetUser') && $request->has('targetTable')){

                        $table = \App\table::find($request->get('targetTable'));

                        $checkExists = \App\users_bookings::where('booking_id','=',$table->currentBooking->id)->where('user_id','=',$request->get('targetUser'))->get();

                        if($checkExists->count() == 0){
                            $userBooking = new \App\users_bookings;
                            $userBooking->booking_id = $table->currentBooking->id;
                            $userBooking->user_id = $request->get('targetUser');
                            $userBooking->save();
                        }

                        if(!$table->is_occupied){
                            $table->startTable();
                        }

                        $data['target'] = \App\table::find($request->get('targetTable')); // needs to recreate the object as it wont otherwise contain our new booking
                        $data['users'] = \App\User::all();
                        $data['usersOnTable'] = $table->currentBooking->users;
                        $data['cancelLimit'] = \App\config::where('name','=','timeToCancelTable')->get()->first()->integer;
                        $return['row'] = \View::make('terminal.loopTemplates.tableRow',['table'=>$data['target']])->render();
                        $return['home'] = \View::make('tablesHomepage',['info'=>$this->generateHomepageData($request)])->render();
                        $return['data'] = \View::make('terminal.tableSummaryModal',['data'=>$data])->render();

                    }else{
                        $return['success']=false;
                        $return['message']='Target User and Target Table not passed to the ajax controller for AddUserToTable';
                    }  
                    return $return;                  
                    break;





/*=========*/
                case 'removeUserFromTable':
                    if($request->has('targetUser') && $request->has('targetTable')){

                        $table = \App\table::find($request->get('targetTable'));

                        $checkExists = \App\users_bookings::where('booking_id','=',$table->currentBooking->id)->where('user_id','=',$request->get('targetUser'))->get();

                        if($checkExists->count() > 0){
                            foreach($checkExists as $toDelete){
                                $toDelete->delete();
                            }
                        }

                        $data['target'] = \App\table::find($request->get('targetTable')); // needs to recreate the object as it wont otherwise contain our new booking
                        $data['users'] = \App\User::all();
                        $data['usersOnTable'] = $table->currentBooking->users;
                        $data['cancelLimit'] = \App\config::where('name','=','timeToCancelTable')->get()->first()->integer;
                        $return['row'] = \View::make('terminal.loopTemplates.tableRow',['table'=>$data['target']])->render();
                        $return['home'] = \View::make('tablesHomepage',['info'=>$this->generateHomepageData($request)])->render();
                        $return['data'] = \View::make('terminal.tableSummaryModal',['data'=>$data])->render();
                        

                    }else{
                        $return['success']=false;
                        $return['message']='Target User and Target Table not passed to the ajax controller for AddUserToTable';
                    }

                    return $return;                    
                    break;



/*=========*/
                case 'errorInAddingUserToTable':
                    if($request->has('targetUser') && $request->has('targetTable')){
                        $data=[];
                        $data['user'] = \App\User::find($request->get('targetUser'));
                        $data['table'] = \App\table::find($request->get('targetTable'));    
                        $data['cancelLimit'] = \App\config::where('name','=','timeToCancelTable')->get()->first()->integer;                    
                        $view = \View::make('terminal.modal.userAccountHasProblemModal')->with('data',$data);
                        $return['data'] = $view->render();
                    }else{
                        $return['success']=false;
                        $return['message']='Target User and Target Table not passed to the ajax controller for errorInAddingUserToTable';
                    }
                    return $return;
                    break;




/*=========*/
                case 'stopTable';
                    if($request->has('targetTable')){

                        $result = \App\table::find($request->get('targetTable'))->stopTable();
                        $table = \App\table::find($request->get('targetTable'));  //after stopTable is called to reflect the changes made

                        if($result['success']){

                            $data['target'] = $table; 
                            $data['users'] = \App\User::all();
                            $data['usersOnTable'] = $table->currentBooking->users;    
                            $data['cancelLimit'] = \App\config::where('name','=','timeToCancelTable')->get()->first()->integer;
                            $return['row'] = \View::make('terminal.loopTemplates.tableRow',['table'=>$table])->render();
                            $return['home'] = \View::make('tablesHomepage',['info'=>$this->generateHomepageData($request)])->render();
                            $return['data'] = \View::make('terminal.tableSummaryModal',['data'=>$data])->render();

                            $return['popover'] = true;
                            $return['closeModal']=true;

                            $return['popoverContent'] =  \View::make('terminal.modal.tableTransferedToTillModalPopover',['info'=>$result])->render();

                        }elseif($result['alert']){
                            $return['alert'] = true;
                            $return['alertContent'] = $result['content'];
                        }else{
                            $return['success']=false;
                            $return['message']=$result['message'];
                        }

                    }else{
                        $return['success']=false;
                        $return['message']='Target Table not passed to the ajax controller for stopTable';
                    }
                    return $return;

                    break;





/*=========*/
                case 'cancelTable';
                    if($request->has('targetTable')){

                        $result = \App\table::find($request->get('targetTable'))->cancelTable();
                        $table = \App\table::find($request->get('targetTable'));  //after stopTable is called to reflect the changes made

                        if($result['success']){

                            $data['target'] = $table; 
                            $data['users'] = \App\User::all();
                            $data['usersOnTable'] = $table->currentBooking->users;   
                            $data['cancelLimit'] = \App\config::where('name','=','timeToCancelTable')->get()->first()->integer;
                            $return['closeModal']=true;                         
                            $return['row'] = \View::make('terminal.loopTemplates.tableRow',['table'=>$table])->render();
                            $return['home'] = \View::make('tablesHomepage',['info'=>$this->generateHomepageData($request)])->render();
                            $return['data'] = \View::make('terminal.tableSummaryModal',['data'=>$data])->render();

                        }elseif($result['alert']){
                            $return['alert'] = true;
                            $return['alertContent'] = $result['content'];
                        }else{
                            $return['success']=false;
                            $return['message']=$result['message'];
                        }

                    }else{
                        $return['success']=false;
                        $return['message']='Target Table not passed to the ajax controller for stopTable';
                    }
                    return $return;

                    break;





/*=========*/
                case 'pauseTable';
                    if($request->has('targetTable')){



                    }else{
                        $return['success']=false;
                        $return['message']='Target Table not passed to the ajax controller for stopTable';
                    }
                    return $return;

                    break;

/*=========*/
    			default:
    				$return['success']=false;
    				$return['message']='No method was passed to the ajax controller';
    				return $return;
    				break;
    		}
    		
    	}else{
    		$return['success']=false;
    		$return['message']='No method was passed to the ajax controller';
    		return $return;
    	}
    }


}
