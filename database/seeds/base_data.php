<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class base_data extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$adminRole = App\role::create([
			'name'=>'Admin'
		]);		

		$memberRole = App\role::create([
			'name'=>'Member'
		]);

 		App\config::create([
            'name' 		=> 	'admin_role_id',
            'integer'	=>	$adminRole->id,
            'group'		=>	'init',
        ]);
		 		
 		App\config::create([
            'name' 		=> 	'standard_member_role_id',
            'integer'	=>	$memberRole->id,
            'group'		=>	'init',
        ]);

        App\config::create([
            'name'      =>  'chargeableInterval',
            'integer'   =>  60,
            'group'     =>  'AdminConfig',
        ]);

        App\config::create([
            'name'      =>  'canPauseTable',
            'boolean'   =>  true,
            'group'     =>  'AdminConfig',
        ]);

        App\config::create([
            'name'      =>  'timeToCancelTable',
            'integer'   =>  300,
            'group'     =>  'AdminConfig',
        ]);

        $admin = App\User::create([
            'fname' 	   => 	'Admin',
            'lname' 	   => 	'User',
            'email' 	   => 	'admin@gmail.com',
            'password' 	   =>	hash::make('123'),
            'role_id'	   =>	$adminRole->id,
            'img_raw'	   =>	'/img/defaultUserImg.png',
            'phone'        =>   '07415863650',
            'addr_line_one'=>   '2 Imperial Court,',
            'addr_line_two'=>   'Mill Lane',
            'town'         =>   'kegworth',
            'county'       =>   'Leicestershire',
            'postcode'      =>  'DE742AL',
        ]);
    }
}
