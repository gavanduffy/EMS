<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;

class StandardsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $standards = ['prekg','lkg','ukg','1','2','3','4','5','6','7','8','9','10','11','12'];
        $order = ['01','02','03','04','05','06','07','08','09','10','11','12','13','14','15'];

        for($i = 0 , $standards , $order ; $i < count($standards) ; $i++) 
        {
            DB::table('standards')->Insert([
                'school_id'         =>  '1',
                'name'              =>  $standards[$i],
                'order'             =>  $order[$i],
                'status'            =>  '1',
                'created_at'        =>   date("Y-m-d H:i:s"),
                'updated_at'        =>   date("Y-m-d H:i:s"),
            ]);

            // DB::table('standards')->Insert([
            //     'school_id'         =>  '2',
            //     'name'              =>  $standards[$i],
            //     'order'             =>  $order[$i],
            //     'status'            =>  '1',
            //     'created_at'        =>   date("Y-m-d H:i:s"),
            //     'updated_at'        =>   date("Y-m-d H:i:s"),
            // ]);
        }

        /*$standardlist = ['prekg' , 'lkg' , 'ukg' , 1 , 2 , 3 , 4 , 5];
        $orderlist = ['01','02','03','04','05','06','07','08'];

        for($i = 0 ; $i < count($standardlist) ; $i++) 
        {
            DB::table('standards')->Insert([
                'school_id'         =>  '3',
                'name'              =>  $standardlist[$i],
                'order'             =>  $orderlist[$i],
                'status'            =>  '1',
                'created_at'        =>   date("Y-m-d H:i:s"),
                'updated_at'        =>   date("Y-m-d H:i:s"),
            ]);
        }*/
    }
}