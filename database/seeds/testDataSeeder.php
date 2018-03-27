<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class testDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		
    /* Create a bunch of users */
        App\User::create([
            'fname'     =>  'Matt',
            'lname'     =>  'Hartley',
            'email'     =>  'matt@gmail.com',
            'password'  =>  hash::make('123'),
            'role_id'   =>  2,
            'img_raw'   =>  '/img/defaultUserImg.png',
        ]);
        App\User::create([
            'fname'     =>  'Ben',
            'lname'     =>  'Crossley',
            'email'     =>  'ben@gmail.com',
            'password'  =>  hash::make('123'),
            'role_id'   =>  2,
            'img_raw'   =>  '/img/defaultUserImg.png',
        ]);
        App\User::create([
            'fname'     =>  'Andy',
            'lname'     =>  'Crossley',
            'email'     =>  'andy@gmail.com',
            'password'  =>  hash::make('123'),
            'role_id'   =>  2,
            'img_raw'   =>  '/img/defaultUserImg.png',
        ]);



    /*  Create the table types  */

        $english = App\table_type::create([
        	'name'				=>	'English Pool',
        	'backgroundClass'	=>	'englishPoolAvailable',
        ]);

        $american = App\table_type::create([
        	'name'	=>	'American Pool',
        	'backgroundClass'	=>	'americanPoolAvailable',
        ]);

        $snooker = App\table_type::create([
        	'name'	=>	'Snooker',
        	'backgroundClass'	=>	'snookerPoolAvailable',
        ]);
        
        $speciality = App\table_type::create([
        	'name'	=>	'Speciality',
        	'backgroundClass'	=>	'specialityAvailable',
        ]); 



    /* Create some tables */

    	$tables =[];
    	$tables[] = array(
    		'number'	=>1,
    		'type_id'	=>$english->id,
    	);
    	$tables[] = array(
    		'number'	=>2,
    		'type_id'	=>$english->id,
    	);
    	$tables[] = array(
    		'number'	=>3,
    		'type_id'	=>$english->id,
    	); 


    	$tables[] = array(
    		'number'	=>4,
    		'type_id'	=>$american->id,
    	);
    	$tables[] = array(
    		'number'	=>5,
    		'type_id'	=>$american->id,
    	);
    	$tables[] = array(
    		'number'	=>6,
    		'type_id'	=>$american->id,
    	);     	  	


		$tables[] = array(
    		'number'	=>7,
    		'type_id'	=>$snooker->id,
    	);
    	$tables[] = array(
    		'number'	=>8,
    		'type_id'	=>$snooker->id,
    	);
    	$tables[] = array(
    		'number'	=>9,
    		'type_id'	=>$snooker->id,
    	);


    	$tables[] = array(
    		'number'	=>10,
    		'type_id'	=>$speciality->id,
    		'name'		=>'Chineese Pool',
    	);
    	
    	$tables[] = array(
    		'number'	=>11,
    		'type_id'	=>$speciality->id,
    		'name'		=>'Round Pool',
    	);
    	
    	$tables[] = array(
    		'number'	=>11,
    		'type_id'	=>$speciality->id,
    		'name'		=>'Billiards',
    	);    	    	

    	foreach($tables as $table){

            $tableCreated = \App\table::create($table);

            $booking = new App\booking;
            $booking->table_id = $tableCreated->id;
            $booking->save();

            $tableCreated->current_booking_id = $booking->id;
            $tableCreated->save();
    	}


    	
    }
}
