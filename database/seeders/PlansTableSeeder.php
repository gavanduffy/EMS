<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;

class PlansTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('plans')->insert([
          
            'cycle'             => '30',
            'name'              => 'standard',
            'display_name'      => 'STANDARD',
            'amount'            => '2000',
            'no_of_members'     => '500',
            'no_of_events'      => '10',
            'no_of_folders'     => '10',
            'no_of_files'       => '10',
            'no_of_videos'      => '10',
            'no_of_bulletins'   => '10',
            'no_of_groups'      => '10',
            'created_at'        => date("Y-m-d H:i:s"),
            'updated_at'        => date("Y-m-d H:i:s"), 

        ]);
         DB::table('plans')->insert([
          
            'cycle'             => '60',
            'name'              => 'extended',
            'display_name'      => 'EXTENDED',
            'amount'            => '5000',
            'no_of_members'     => '2000',
            'no_of_events'      => '30',
            'no_of_folders'     => '30',
            'no_of_files'       => '30',
            'no_of_videos'      => '30',
            'no_of_bulletins'   => '30',
            'no_of_groups'      => '30',
            'created_at'        => date("Y-m-d H:i:s"),
            'updated_at'        => date("Y-m-d H:i:s"), 

        ]);
         DB::table('plans')->insert([
          
            'cycle'             => '90',
            'name'              => 'premium',
            'display_name'      => 'PREMIUM',
            'amount'            => '15000',
            'no_of_members'     => '3000',
            'no_of_events'      => '50',
            'no_of_folders'     => '50',
            'no_of_files'       => '50',
            'no_of_videos'      => '50',
            'no_of_bulletins'   => '50',
            'no_of_groups'      => '50',
            'created_at'        => date("Y-m-d H:i:s"),
            'updated_at'        => date("Y-m-d H:i:s"), 

        ]);

    }
}
