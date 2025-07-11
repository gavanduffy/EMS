<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;
use App\Models\School;

class AcademicYearsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $schools = School::where('status',1)->get();

        foreach ($schools as $school) 
        {
            DB::table('academic_years')->Insert([
                'school_id'    =>  $school->id,
                'name'         =>  '2023-2024',
                'description'  =>  'This is Current Academic Year',
                'start_date'   =>  '2023-06-01',
                'end_date'     =>  '2024-04-30',
                'status'       =>  '1',
                'created_at'   =>   date("Y-m-d H:i:s"),
                'updated_at'   =>   date("Y-m-d H:i:s"),
            ]);

            DB::table('academic_years')->Insert([
                'school_id'    =>  $school->id,
                'name'         =>  '2024-2025',
                'description'  =>  'This is Next Academic Year',
                'start_date'   =>  '2024-06-01',
                'end_date'     =>  '2025-04-30',
                'status'       =>  '1',
                'created_at'   =>   date("Y-m-d H:i:s"),
                'updated_at'   =>   date("Y-m-d H:i:s"),
            ]);
        }
    }
}