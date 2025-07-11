<?php

use App\Models\User;
use Tests\DuskTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class MemberTest extends DuskTestCase
{

    //use DatabaseMigrations;

     public function setUp() :void
    {
        //var_dump(env('DB_DATABASE'));
        parent::setUp();
        $this->runFreshMigrationAndSeed();
    }

    /**
     * A Dusk test example.
     * @test
     * @return void
     */
    public function AdminLogin()
    {
        $this->browse(function ($browser) {
            
            $testuser = User::find(2);

            $browser->visit('/login')
                    ->type('#email', $testuser->email)
                    ->type('#password', 'password')
                    ->pause(2000)
                    ->press('#login')          
                    ->assertPathIs('/admin/dashboard');         
        });
    }


    /**
     * A Dusk test example.
     *@test
     * @return void
     */
    public function AddMemberSuccess()
    {
        $this->AdminLogin();

        $this->browse(function ($browser) {
            $testuser = User::find(2);

            $browser->click('#app > div.flex.flex-col.lg\:flex-row.md\:flex-row.min-h-full > div.w-full.lg\:w-40.md\:w-40.admin-sidebar > div > ul > li:nth-child(2) > a > span')
                    ->assertPathIs('/admin/members')
                    ->pause(2000)
                    ->click('@add-button')
                    ->visit('/admin/member/add')
                    ->type('#name','Abayomrunkoje')
                    ->type('#firstname','Abayom')
                    ->type('#lastname','runkoje')
                    ->attach('#avatar', __DIR__.'/../photos/photo.jpg')
                    ->type('#date_of_birth','07-09-1988')
                    ->type('#aadhar_number','123456789012')
                    ->radio('#gender1','male')
                    ->select('#was_baptized','yes')
                    ->type('#baptism_date','07-09-1989')
                    ->select('#profession','business')
                    ->type('#mobile_no','7894561230')
                    ->type('#email','abayomrunkoje@church.com')
                    ->select('#membership_type','member')
                    ->select('#country_id','7')
                    ->select('#city_id','31')
                    ->select('#state_id','24')
                    ->type('#pincode','625001')
                    ->type('#family','Jory')
                    ->select('#marriage_status','single')
                    ->type('#notes','Welcome')
                    ->type('#address','Madurai')
                    ->click('@getCords')
                    ->click('@submit-btn')
                    ->assertPathIs('/admin/member/add')
                    ->pause(5000)
                    ->assertSee('Member Added Successfully')
                    ->click('@profile-menu')
                    ->assertSee($testuser->email)
                    ->click('@logout-link')
                    ->assertPathIs('/');
        });          
    } 

    /**
     * A Dusk test example.
     *@test
     * @return void
     */
    public function AddGuest()
    {
        $this->Login();

        $this->browse(function ($browser) {
            $testuser = User::find(2);

            $browser->click('#app > div.flex.flex-col.lg\:flex-row.md\:flex-row.min-h-full > div.w-full.lg\:w-40.md\:w-40.admin-sidebar > div > ul > li:nth-child(2) > a > span')
                    ->assertPathIs('/admin/members')
                    ->pause(2000)
                    ->click('@add-button')
                    ->visit('/admin/member/add')
                    ->type('#name','Abayomrunkoje')
                    ->type('#firstname','Abayom')
                    ->type('#lastname','runkoje')
                    ->attach('#avatar', __DIR__.'/../photos/photo.jpg')
                    ->type('#date_of_birth','07-09-1988')
                    ->type('#aadhar_number','123456789012')
                    ->radio('#gender1','male')
                    ->select('#was_baptized','no')
                    ->select('#profession','business')
                    ->type('#mobile_no','7894561230')
                    ->type('#email','abayomrunkoje@church.com')
                    ->select('#membership_type','guest')
                    ->select('#country_id','7')
                    ->select('#city_id','31')
                    ->select('#state_id','24')
                    ->type('#pincode','625001')
                    ->type('#family','Jory')
                    ->select('#marriage_status','single')
                    ->type('#notes','Welcome')
                    ->type('#address','Madurai')
                    ->click('@getCords')
                    ->click('@submit-btn')
                    ->assertPathIs('/admin/member/add')
                    ->pause(5000)
                    ->assertSee('Member Added Successfully')
                    ->click('@profile-menu')
                    ->assertSee($testuser->email)
                    ->click('@logout-link')
                    ->assertPathIs('/');
        });          
    } 

 
    /**
     * A Dusk test example.
     *@test
     * @return void
     */
    public function AddMemberFailure()
    {
        $this->Login();

        $this->browse(function ($browser) {
            $testuser = User::find(2);

            $browser->click('#app > div.flex.flex-col.lg\:flex-row.md\:flex-row.min-h-full > div.w-full.lg\:w-40.md\:w-40.admin-sidebar > div > ul > li:nth-child(2) > a > span')
                    ->assertPathIs('/admin/members')
                    ->pause(2000)
                    ->click('@add-button')
                    ->visit('/admin/member/add')
                    ->click('@submit-btn')
                    ->assertPathIs('/admin/member/add')
                    ->pause(5000)
                    ->assertSee('First Name is required')
                    ->assertSee('User Name is required')
                    ->assertSee('Avatar is required')
                    ->assertSee('Date Of Birth is required')
                    ->assertSee('Aadhar Number is required')
                    ->assertSee('Gender is required')
                    ->assertSee('Baptism is required')
                    ->assertSee('Profession is required')
                    ->assertSee('Mobile Number is required')
                    ->assertSee('Email ID is required')
                    ->assertSee('Membership Type is required')
                    ->assertSee('City is required')
                    ->assertSee('State is required')
                    ->assertSee('Pincode is required')
                    ->assertSee('Family is required')
                    ->assertSee('Marriage Status is required')
                    ->click('@profile-menu')
                    ->assertSee($testuser->email)
                    ->click('@logout-link')
                    ->assertPathIs('/');
        });          
    }  


     /**
     * A Dusk test example.
     *@test
     * @return void
     */
    public function EditMember1()
    {
        $this->Login();

        $this->browse(function ($browser) {
            $testuser = User::find(2);
            $edituser = User::with('userprofile')->where('church_id','1')->where('usergroup_id','5')->first();
            $firstname = $edituser->userprofile->firstname;

            $browser->visit('/admin/member/edit/'.$firstname)
                    ->pause(1000)
                    ->click('#app > div.flex.flex-col.lg\:flex-row.md\:flex-row.min-h-full > div.w-full.px-5.py-3 > main > div > form > div:nth-child(3) > div > div > label')
                    ->attach('#avatar', __DIR__.'/../photos/photo.jpg')
                    ->pause(2000)
                    ->type('#lastname','runkoje')
                    ->radio('#gender','male')
                    ->type('#date_of_birth','07-09-1988')
                    ->type('#aadhar_number','123456789012')
                    ->select('#profession','business')
                    ->select('#was_baptized','no')
                    ->type('#address','Madurai')
                    ->click('@getCords')
                    ->select('#country_id','7')
                    ->select('#city_id','31')
                    ->select('#state_id','24')
                    ->type('#pincode','625001')
                    ->pause(1000)
                    ->select('#membership_type','member')
                    ->type('#family','Jory')
                    ->select('#marriage_status','single')
                    ->type('#notes','Welcome')
                    ->pause(1000)
                    ->click('@submit')
                    ->pause(1000)
                    ->assertPathIs('/admin/member/edit/'.$firstname)
                    ->pause(5000)
                    ->assertSee('Member Details Updated Successfully')
                    ->click('@profile-menu')
                    ->assertSee($testuser->email)
                    ->click('@logout-link')
                    ->assertPathIs('/');
        });          
    } 

    /**
     * A Dusk test example.
     *@test
     * @return void
     */
    public function EditMember2()
    {
        $this->Login();

        $this->browse(function ($browser) {
            $testuser = User::find(2);
            $edituser = User::with('userprofile')->where('church_id','1')->where('usergroup_id','5')->first();
            $name = $edituser->name;
            $firstname = $edituser->userprofile->firstname;

            $browser->click('#app > div.flex.flex-col.lg\:flex-row.md\:flex-row.min-h-full > div.w-full.lg\:w-40.md\:w-40.admin-sidebar > div > ul > li:nth-child(2) > a > span')
                    ->assertPathIs('/admin/members')
                    ->pause(2000)
                    ->click('#app > div.flex.flex-col.lg\:flex-row.md\:flex-row.min-h-full > div.w-full.px-5.py-3 > main > div > div:nth-child(3) > div:nth-child(2) > div.my-8 > div > div:nth-child(1) > div > div > h2')
                    ->pause(5000)
                    ->click('#show-detail > div > div > div.w-4\/5.px-3.lg\:px-0.md\:px-0 > div.pt-3.border-t > a > span')
                    ->pause(2000)
                    ->assertPathIs('/admin/member/show/'.$name)
                    ->click('#edit')
                    ->assertPathIs('/admin/member/edit/'.$firstname)
                    ->pause(2000)
                    ->click('#app > div.flex.flex-col.lg\:flex-row.md\:flex-row.min-h-full > div.w-full.px-5.py-3 > main > div > form > div:nth-child(3) > div > div > label')
                    ->attach('#avatar', __DIR__.'/../photos/photo.jpg')
                    ->pause(2000)
                    ->type('#lastname','runkoje')
                    ->pause(2000)
                    ->radio('#gender','male')
                    ->type('#date_of_birth','07-09-1988')
                    ->type('#aadhar_number','123456789012')
                    ->select('#profession','business')
                    ->select('#was_baptized','no')
                    ->type('#address','Madurai')
                    ->click('@getCords')
                    ->select('#country_id','7')
                    ->select('#city_id','31')
                    ->select('#state_id','24')
                    ->type('#pincode','625001')
                    ->pause(5000)
                    ->select('#membership_type','member')
                    ->type('#family','Jory')
                    ->select('#marriage_status','single')
                    ->type('#notes','Welcome')
                    ->pause(20000)
                    ->click('@submit')
                    ->pause(2000)
                    ->assertPathIs('/admin/member/edit/'.$firstname)
                    ->pause(15000)
                    ->assertSee('Member Details Updated Successfully')
                    ->click('@profile-menu')
                    ->assertSee($testuser->email)
                    ->click('@logout-link')
                    ->assertPathIs('/');
        });          
    } 
}