<?php

use App\Models\User;
use Tests\DuskTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ValidationTest extends DuskTestCase
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
    public function Login()
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

//Checking Name Validation
    /**
     * A Dusk test example.
     *@test
     * @return void
     */
    public function Name()
    {
        $this->Login();

        $this->browse(function ($browser) {
            $testuser = User::find(1);
            $loguser = User::find(2);

            $browser->click('#app > div.flex.flex-col.lg\:flex-row.md\:flex-row.min-h-full > div.w-full.lg\:w-40.md\:w-40.admin-sidebar > div > ul > li:nth-child(2) > a > span')
                    ->assertPathIs('/admin/members')
                    ->pause(2000)
                    ->click('@add-button')
                    ->visit('/admin/member/add')
                    ->type('#name',$testuser->name)
                    ->type('#firstname','Abayomrunkojedfg')
                    ->type('#lastname','Abayomrunkojedfg5')
                    ->attach('#avatar', __DIR__.'/../photos/photo.jpg')
                    ->type('#date_of_birth','07-09-1988')
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
                    ->type('#ward','10')
                    ->type('#giving_no','15')
                    ->type('#notes','Welcome')
                    ->type('#address','Madurai')
                    ->click('@getCords')
                    ->click('@submit-btn')
                    ->assertPathIs('/admin/member/add')
                    ->pause(5000)
                    ->assertSee('User Name already in use. Try different User Name')
                    ->assertSee('The firstname may not be greater than 15 characters.')
                    ->assertSee('Enter a Valid Last Name')
                    ->click('@profile-menu')
                    ->assertSee($loguser->email)
                    ->click('@logout-link')
                    ->assertPathIs('/');
        });          
    }


       /**
     * A Dusk test example.
     *@test
     * @return void
     */

//Validation for Avatar and Date of birth

    public function Avatar()
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
                    ->attach('#avatar', __DIR__.'/../files/threemb.pdf')
                    ->type('#date_of_birth','07-09-1919')
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
                    ->type('#ward','10')
                    ->type('#giving_no','15')
                    ->type('#notes','Welcome')
                    ->type('#address','Madurai')
                    ->click('@getCords')
                    ->click('@submit-btn')
                    ->assertPathIs('/admin/member/add')
                    ->pause(5000)
                    ->assertSee('Choose an image file')
                    ->assertSee('Enter valid Date Of Birth')
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
//unique mobile and email
  public function unique_mobile_email()
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
                    ->radio('#gender1','male')
                    ->select('#was_baptized','yes')
                    ->type('#baptism_date','07-09-1989')
                    ->select('#profession','business')
                    ->type('#mobile_no','fhjgfhjfhfhgf')
                    ->type('#email',$testuser->email)
                    ->select('#membership_type','member')
                    ->select('#country_id','7')
                    ->select('#city_id','31')
                    ->select('#state_id','24')
                    ->type('#pincode','6250010')
                    ->type('#family','Jory')
                    ->select('#marriage_status','single')
                    ->type('#ward','10')
                    ->type('#giving_no','15')
                    ->type('#notes','Welcome')
                    ->type('#address','Madurai')
                    ->click('@getCords')
                    ->click('@submit-btn')
                    ->assertPathIs('/admin/member/add')
                    ->pause(5000)
                    ->assertSee('Mobile Number should be numeric')
                    ->assertSee('Email ID already in use. Enter different Email ID')
                    ->assertSee('The pincode must be 6 digits.')
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
//mobile_no exceed and email mismatch
  public function failure_email_mobile()
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
                    ->radio('#gender1','male')
                    ->select('#was_baptized','yes')
                    ->type('#baptism_date','07-09-1989')
                    ->select('#profession','business')
                    ->type('#mobile_no','78945612303')
                    ->type('#email',$testuser->name)
                    ->select('#membership_type','member')
                    ->select('#country_id','7')
                    ->select('#city_id','31')
                    ->select('#state_id','24')
                    ->type('#pincode','jkhkjhkjh')
                    ->type('#family','Jory')
                    ->select('#marriage_status','single')
                    ->type('#ward','10')
                    ->type('#giving_no','15')
                    ->type('#notes','Welcome')
                    ->type('#address','Madurai')
                    ->click('@getCords')
                    ->click('@submit-btn')
                    ->assertPathIs('/admin/member/add')
                    ->pause(5000)
                    ->assertSee('The mobile no must be 10 digits.')
                    ->assertSee('Enter a valid Email ID')
                    ->assertSee('Pincode should be numeric')
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
//Validation for family, ward and notes
  public function family_notes()
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
                    ->type('#family','<guuiuy@')
                    ->select('#marriage_status','single')
                    ->type('#ward','jhghj')
                    ->type('#giving_no','5')
                    ->type('#notes','<jkhuih')
                    ->type('#address','Madurai')
                    ->click('@getCords')
                    ->click('@submit-btn')
                    ->assertPathIs('/admin/member/add')
                    ->pause(5000)
                    ->assertSee('Enter a Valid Family Name')
                    ->assertSee('Ward should be Numeric')
                    ->assertSee('Enter Valid Notes')
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

    public function AddMaleMarriage()
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
                    ->select('#marriage_status','married')
                    ->type('#marriage_start_date','22-04-2007')
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
    public function AddFemaleMarriage()
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
                    ->radio('#gender2','female')
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
                    ->select('#marriage_status','married')
                    ->type('#marriage_start_date','22-04-2007')
                    ->type('#address','Madurai')
                    ->click('@getCords')
                    ->click('@submit-btn')
                    ->assertPathIs('/admin/member/add')
                    ->pause(10000)
                    ->assertSee('Enter Valid Marriage Start Date')
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
   
    public function Alphabet_filter()
    {
        $this->Login();

        $this->browse(function ($browser) {
            $testuser = User::find(2);

            //$filteruser = User::with('userprofile')->where('church_id','1')->where('usergroup_id','5')->where('firstname','LIKE','%'.'A'.'%')->get();
             //dd($filteruser);

            $browser->visit('/admin/members')
                    ->click('#filter','B')
                    ->pause(5000);

                });

     }


}