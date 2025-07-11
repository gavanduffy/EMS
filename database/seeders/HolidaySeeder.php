<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;
use App\Models\AcademicYear;
use App\Helpers\SiteHelper;
use App\Models\School;

class HolidaySeeder extends Seeder
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
            $academic_year = AcademicYear::where([['school_id',$school->id],['status',1]])->first();
            DB::table('events')->Insert([
                'school_id'        => $school->id,
                'academic_year_id' => $academic_year->id,
                'select_type'      => 'school',
                'title'            => 'Bakrid',
                'category'         => 'holidays',
                'start_date'       => '2020-08-01 00:00:00',
                'end_date'         => '2020-08-02 00:00:00',
                'created_at'       =>   date("Y-m-d H:i:s"),
                'updated_at'       =>   date("Y-m-d H:i:s"),
            ]);

            DB::table('events')->Insert([
                'school_id'        => $school->id,
                'academic_year_id' => $academic_year->id,
                'select_type'      => 'school',
                'title'            => 'Krishna Jeyanthi',
                'category'         => 'holidays',
                'start_date'       => '2020-08-11 00:00:00',
                'end_date'         => '2020-08-12 00:00:00',
                'created_at'       =>   date("Y-m-d H:i:s"),
                'updated_at'       =>   date("Y-m-d H:i:s"),
            ]);

            DB::table('events')->Insert([
                'school_id'        => $school->id,
                'academic_year_id' => $academic_year->id,
                'select_type'      => 'school',
                'title'            => 'Independence Day',
                'category'         => 'holidays',
                'start_date'       => '2020-08-15 00:00:00',
                'end_date'         => '2020-08-16 00:00:00',
                'created_at'       =>   date("Y-m-d H:i:s"),
                'updated_at'       =>   date("Y-m-d H:i:s"),
            ]);

            DB::table('events')->Insert([
                'school_id'        => $school->id,
                'academic_year_id' => $academic_year->id,
                'select_type'      => 'school',
                'title'            => 'Vinayakar Chathurthi',
                'category'         => 'holidays',
                'start_date'       => '2020-08-22 00:00:00',
                'end_date'         => '2020-08-23 00:00:00',
                'created_at'       =>   date("Y-m-d H:i:s"),
                'updated_at'       =>   date("Y-m-d H:i:s"),
            ]);

            DB::table('events')->Insert([
                'school_id'        => $school->id,
                'academic_year_id' => $academic_year->id,
                'select_type'      => 'school',
                'title'            => 'Muharram',
                'category'         => 'holidays',
                'start_date'       => '2020-08-03 00:00:00',
                'end_date'         => '2020-08-04 00:00:00',
                'created_at'       =>   date("Y-m-d H:i:s"),
                'updated_at'       =>   date("Y-m-d H:i:s"),
            ]);

            DB::table('events')->Insert([
                'school_id'        => $school->id,
                'academic_year_id' => $academic_year->id,
                'select_type'      => 'school',
                'title'            => 'Gandhi Jeyanthi',
                'category'         => 'holidays',
                'start_date'       => '2020-10-02 00:00:00',
                'end_date'         => '2020-10-03 00:00:00',
                'created_at'       =>   date("Y-m-d H:i:s"),
                'updated_at'       =>   date("Y-m-d H:i:s"),
            ]);

            DB::table('events')->Insert([
                'school_id'        => $school->id,
                'academic_year_id' => $academic_year->id,
                'select_type'      => 'school',
                'title'            => 'Ayutha Pooja',
                'category'         => 'holidays',
                'start_date'       => '2020-10-25 00:00:00',
                'end_date'         => '2020-10-26 00:00:00',
                'created_at'       =>   date("Y-m-d H:i:s"),
                'updated_at'       =>   date("Y-m-d H:i:s"),
            ]);

            DB::table('events')->Insert([
                'school_id'        => $school->id,
                'academic_year_id' => $academic_year->id,
                'select_type'      => 'school',
                'title'            => 'Vijaya Dasami',
                'category'         => 'holidays',
                'start_date'       => '2020-10-26 00:00:00',
                'end_date'         => '2020-10-27 00:00:00',
                'created_at'       =>   date("Y-m-d H:i:s"),
                'updated_at'       =>   date("Y-m-d H:i:s"),
            ]);

            DB::table('events')->Insert([
                'school_id'        => $school->id,
                'academic_year_id' => $academic_year->id,
                'select_type'      => 'school',
                'title'            => 'Mila-un-Nabi',
                'category'         => 'holidays',
                'start_date'       => '2020-10-30 00:00:00',
                'end_date'         => '2020-10-31 00:00:00',
                'created_at'       =>   date("Y-m-d H:i:s"),
                'updated_at'       =>   date("Y-m-d H:i:s"),
            ]);

            DB::table('events')->Insert([
                'school_id'        => $school->id,
                'academic_year_id' => $academic_year->id,
                'select_type'      => 'school',
                'title'            => 'Deepavali',
                'category'         => 'holidays',
                'start_date'       => '2020-11-14 00:00:00',
                'end_date'         => '2020-11-15 00:00:00',
                'created_at'       =>   date("Y-m-d H:i:s"),
                'updated_at'       =>   date("Y-m-d H:i:s"),
            ]);

            DB::table('events')->Insert([
                'school_id'        => $school->id,
                'academic_year_id' => $academic_year->id,
                'select_type'      => 'school',
                'title'            => 'Christmas',
                'category'         => 'holidays',
                'start_date'       => '2020-12-25 00:00:00',
                'end_date'         => '2020-12-26 00:00:00',
                'created_at'       =>   date("Y-m-d H:i:s"),
                'updated_at'       =>   date("Y-m-d H:i:s"),
            ]);


            DB::table('events')->Insert([
                'school_id'        => $school->id,
                'academic_year_id' => $academic_year->id,
                'select_type'      => 'school',
                'title'            => 'New Year',
                'category'         => 'holidays',
                'start_date'       => '2021-01-01 00:00:00',
                'end_date'         => '2021-01-02 00:00:00',
                'created_at'       =>   date("Y-m-d H:i:s"),
                'updated_at'       =>   date("Y-m-d H:i:s"),
            ]);

            DB::table('events')->Insert([
                'school_id'        => $school->id,
                'academic_year_id' => $academic_year->id,
                'select_type'      => 'school',
                'title'            => 'Pongal',
                'category'         => 'holidays',
                'start_date'       => '2021-01-14 00:00:00',
                'end_date'         => '2021-01-15 00:00:00',
                'created_at'       =>   date("Y-m-d H:i:s"),
                'updated_at'       =>   date("Y-m-d H:i:s"),
            ]);

            DB::table('events')->Insert([
                'school_id'        => $school->id,
                'academic_year_id' => $academic_year->id,
                'select_type'      => 'school',
                'title'            => 'Thiruvalluvar Day',
                'category'         => 'holidays',
                'start_date'       => '2021-01-15 00:00:00',
                'end_date'         => '2021-01-16 00:00:00',
                'created_at'       =>   date("Y-m-d H:i:s"),
                'updated_at'       =>   date("Y-m-d H:i:s"),
            ]);

            DB::table('events')->Insert([
                'school_id'        => $school->id,
                'academic_year_id' => $academic_year->id,
                'select_type'      => 'school',
                'title'            => 'Republic Day',
                'category'         => 'holidays',
                'start_date'       => '2021-01-26 00:00:00',
                'end_date'         => '2021-01-27 00:00:00',
                'created_at'       =>   date("Y-m-d H:i:s"),
                'updated_at'       =>   date("Y-m-d H:i:s"),
            ]);

            DB::table('events')->Insert([
                'school_id'        => $school->id,
                'academic_year_id' => $academic_year->id,
                'select_type'      => 'school',
                'title'            => 'Good Friday',
                'category'         => 'holidays',
                'start_date'       => '2021-04-02 00:00:00',
                'end_date'         => '2021-04-03 00:00:00',
                'created_at'       =>   date("Y-m-d H:i:s"),
                'updated_at'       =>   date("Y-m-d H:i:s"),
            ]);

            DB::table('events')->Insert([
                'school_id'        => $school->id,
                'academic_year_id' => $academic_year->id,
                'select_type'      => 'school',
                'title'            => 'Telugu New Year',
                'category'         => 'holidays',
                'start_date'       => '2021-04-13 00:00:00',
                'end_date'         => '2021-04-13 00:00:00',
                'created_at'       =>   date("Y-m-d H:i:s"),
                'updated_at'       =>   date("Y-m-d H:i:s"),
            ]);

            DB::table('events')->Insert([
                'school_id'        => $school->id,
                'academic_year_id' => $academic_year->id,
                'select_type'      => 'school',
                'title'            => 'Tamil New Year',
                'category'         => 'holidays',
                'start_date'       => '2021-04-14 00:00:00',
                'end_date'         => '2021-04-14 00:00:00',
                'created_at'       =>   date("Y-m-d H:i:s"),
                'updated_at'       =>   date("Y-m-d H:i:s"),
            ]);

            DB::table('events')->Insert([
                'school_id'        => $school->id,
                'academic_year_id' => $academic_year->id,
                'select_type'      => 'school',
                'title'            => 'Mahavir Jeyanthi',
                'category'         => 'holidays',
                'start_date'       => '2021-04-25 00:00:00',
                'end_date'         => '2021-04-26 00:00:00',
                'created_at'       =>   date("Y-m-d H:i:s"),
                'updated_at'       =>   date("Y-m-d H:i:s"),
            ]);
        }        
    }
}