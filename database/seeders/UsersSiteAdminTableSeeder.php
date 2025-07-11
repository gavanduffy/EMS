<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Userprofile;
use Carbon\Carbon;

class UsersSiteAdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $siteAdmin = User::factory()->create([
            'name'         =>   'siteadmin',
            'email'        =>   'siteadmin@gegok12.com',
            'password'     =>   bcrypt('password'),
            'mobile_no'    =>   '1230456789',
            'usergroup_id' =>   "1"
        ]);
        //dd($siteAdmin->id);

        Userprofile::factory()->create([
            'user_id'       =>  $siteAdmin->id,
            'usergroup_id'  =>  1,
            'firstname'     =>  'siteadmin',
            'lastname'      =>  'siteadmin',
            'profession'    =>  'admin',
            'address'       =>  'Nammakal,Tamilnadu,India',
            'country_id'    =>  '7',
            'city_id'       =>  '31',
            'state_id'      =>  '24',
            'pincode'       =>  '625001'
        ]);
    }
}