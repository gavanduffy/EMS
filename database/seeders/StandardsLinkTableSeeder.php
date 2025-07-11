<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;
use App\Helpers\SiteHelper;
use App\Models\Standard;
use App\Models\Section;
use App\Models\School;
use App\Models\User;

class StandardsLinkTableSeeder extends Seeder
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
            $standards = Standard::where('school_id',$school->id)->get();
            $sections = Section::where('school_id',$school->id)->get();
            $teachers = User::where([['school_id',$school->id],['usergroup_id', 5]])->pluck('id')->toArray();

            foreach($standards as $stdKey => $standard)
            {
                foreach ($sections as $secKey => $section)
                {
                    $academic_year = SiteHelper::getAcademicyear($school->id);
                    $sectionRef = $stdKey * $sections->count() + $secKey + 1;
                    factory(\App\Models\StandardLink::class, 1)->create([

                        'school_id'         =>  $standard->school_id,
                        'academic_year_id'  =>  $academic_year->id,
                        'standard_id'       =>  $standard->id,
                        'section_id'        =>  $section->id,
                        'class_teacher_id'  =>  $teachers[$sectionRef]
                    ]);

                    factory(\App\Models\RoleUser::class, 1)->create([
                        'user_id'   =>  $teachers[$sectionRef],
                        'role_id'   =>  4, 
                    ]);
                }
            }
        }
    }
}