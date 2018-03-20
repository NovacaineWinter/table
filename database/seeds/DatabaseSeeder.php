<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(testDataSeeder::class); //this is for testing data only
        $this->call(base_data::class);
    }
}
