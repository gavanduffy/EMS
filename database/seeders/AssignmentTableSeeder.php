<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;

class AssignmentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('assignments')->Insert([
            array(
            	'id' 				=> '1',
            	'school_id' 		=> '1',
            	'academic_year_id'	=> '1',
            	'standardLink_id' 	=> '1',
            	'subject_id' 		=> '1',
            	'teacher_id' 		=> '363',
            	'title' 			=> 'Test',
            	'description' 		=> 'Dolor morbi non arcu risus quis varius quam quisque id. Commodo ullamcorper a lacus vestibulum sed arcu non odio euismod. Elit ullamcorper dignissim cras tincidunt lobortis feugiat.',
            	'attachment' 		=> NULL,
            	'marks' 			=> '20',
            	'assigned_date' 	=> '2020-04-17 00:00:00',
            	'submission_date' 	=> '2020-04-24 00:00:00',
            	'status' 			=> 'ongoing',
            	'created_at' 		=> '2020-04-17 14:03:45',
            	'updated_at' 		=> '2020-04-17 14:03:45',
            	'deleted_at' 		=> NULL
            ),
            array(
            	'id' 				=> '2',
            	'school_id' 		=> '1',
            	'academic_year_id' 	=> '1',
            	'standardLink_id' 	=> '2',
            	'subject_id' 		=> '1',
            	'teacher_id' 		=> '363',
            	'title' 			=> 'Example',
            	'description' 		=> 'Eget nunc scelerisque viverra mauris in aliquam. Posuere morbi leo urna molestie at elementum. Est pellentesque elit ullamcorper dignissim cras tincidunt lobortis feugiat.',
            	'attachment' 		=> NULL,
            	'marks' 			=> '30',
            	'assigned_date' 	=> '2020-04-18 00:00:00',
            	'submission_date' 	=> '2020-04-25 00:00:00',
            	'status' 			=> 'pending',
            	'created_at' 		=> '2020-04-17 14:04:20',
            	'updated_at' 		=> '2020-04-17 14:04:20',
            	'deleted_at' 		=> NULL
            ),
            array(
            	'id' 				=> '3',
            	'school_id' 		=> '1',
            	'academic_year_id' 	=> '1',
            	'standardLink_id' 	=> '1',
            	'subject_id' 		=> '1',
            	'teacher_id' 		=> '363',
            	'title' 			=> 'Test',
            	'description' 		=> 'Ac tincidunt vitae semper quis lectus nulla. Ultricies integer quis auctor elit sed vulputate mi sit amet. Dolor morbi non arcu risus quis varius quam quisque id. Commodo ullamcorper a lacus vestibulum sed arcu non odio euismod.',
            	'attachment' 		=> 'uploads/file.pdf',
            	'marks' 			=> '10',
            	'assigned_date' 	=> '2020-03-02 00:00:00',
            	'submission_date' 	=> '2020-03-09 00:00:00',
            	'status' 			=> 'completed',
            	'created_at' 		=> '2020-04-17 14:15:17',
            	'updated_at' 		=> '2020-04-17 14:15:17',
            	'deleted_at' 		=> NULL
            ),
            array(
            	'id' 				=> '4',
            	'school_id' 		=> '1',
            	'academic_year_id' 	=> '1',
            	'standardLink_id' 	=> '2',
            	'subject_id' 		=> '1',
            	'teacher_id' 		=> '363',
            	'title' 			=> 'Test',
            	'description' 		=> 'Ac tincidunt vitae semper quis lectus nulla. Ultricies integer quis auctor elit sed vulputate mi sit amet. Dolor morbi non arcu risus quis varius quam quisque id. Commodo ullamcorper a lacus vestibulum sed arcu non odio euismod.',
            	'attachment' 		=> 'uploads/file.pdf',
            	'marks' 			=> '15',
            	'assigned_date' 	=> '2020-04-19 00:00:00',
            	'submission_date' 	=> '2020-04-22 00:00:00',
            	'status' 			=> 'pending',
            	'created_at' 		=> '2020-04-17 14:34:56',
            	'updated_at' 		=> '2020-04-17 14:40:31',
            	'deleted_at' 		=> NULL
            ),
            array(
            	'id' 				=> '5',
            	'school_id' 		=> '1',
            	'academic_year_id' 	=> '1',
            	'standardLink_id' 	=> '1',
            	'subject_id' 		=> '1',
            	'teacher_id' 		=> '363',
            	'title' 			=> 'Test',
            	'description' 		=> 'Tincidunt nunc pulvinar sapien et. Donec pretium vulputate sapien nec sagittis aliquam malesuada bibendum arcu. Dui sapien eget mi proin sed libero enim sed faucibus.',
            	'attachment' 		=> NULL,
            	'marks' 			=> '15',
            	'assigned_date' 	=> '2020-04-17 00:00:00',
            	'submission_date' 	=> '2020-04-22 00:00:00',
            	'status' 			=> 'ongoing',
            	'created_at' 		=> '2020-04-17 18:23:21',
            	'updated_at' 		=> '2020-04-17 18:23:21',
            	'deleted_at' 		=> NULL
            )
        ]);
    }
}
