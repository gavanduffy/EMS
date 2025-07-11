<?php

use App\Models\User;
use Tests\DuskTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ImportExportTest extends DuskTestCase
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


    /**
     * A Dusk test example.
     *@test
     * @return void
     */

   /* public function Import()
    {
        $this->Login();

        $browser->visit('/admin/members')
                ->click('#import-button')
                 ->attach('#file', __DIR__.'/../files/1mb.csv')
    }*/


    /**
     * A Dusk test example.
     *@test
     * @return void
     */

    public function ExportbyUsername()
    {
        $this->Login();

         $this->browse(function ($browser) {

            $searchuser=User::with('userprofile')->where('church_id','1')->where('usergroup_id','5')->first();

        $browser->visit('/admin/members')
                ->type('#name',$searchuser->name)
                ->pause(2000)
                ->click('@show')
                ->pause(1000)
                ->click('@search-btn')
                ->pause(2000)
                ->click('#export-button')
                ->pause(5000)
                ->click('@show')
                ->pause(1000) 
                ->click('@reset-btn')
                ->pause(2000);

        });

    }

      /**
     * A Dusk test example.
     *@test
     * @return void
     */


    public function Exportbyfirstname()
    {
        $this->Login();

         $this->browse(function ($browser) {

            $searchuser=User::with('userprofile')->where('church_id','1')->where('usergroup_id','5')->first();

        $browser->visit('/admin/members')
                ->click('@show')
                ->pause(1000)
                ->type('#firstname',$searchuser->userprofile->firstname)
                ->pause(2000)
                ->click('@search-btn')
                ->pause(2000)
                ->click('#export-button')
                ->pause(5000)
                ->click('@show')
                ->pause(1000) 
                ->click('@reset-btn')
                ->pause(2000);

        });

    }

      /**
     * A Dusk test example.
     *@test
     * @return void
     */

    public function Exportbylastname()
    {
        $this->Login();

         $this->browse(function ($browser) {

            $searchuser=User::with('userprofile')->where('church_id','1')->where('usergroup_id','5')->first();

        $browser->visit('/admin/members')
                ->click('@show')
                ->pause(1000)
                ->type('#lastname',$searchuser->userprofile->lastname)
                ->pause(2000)
                ->click('@search-btn')
                ->pause(2000)
                ->click('#export-button')
                ->pause(5000)
                ->click('@show')
                ->pause(1000) 
                ->click('@reset-btn')
                ->pause(2000);

        });

    }

      /**
     * A Dusk test example.
     *@test
     * @return void
     */

    public function Exportbygender()
    {
        $this->Login();

         $this->browse(function ($browser) {

            $searchuser=User::with('userprofile')->where('church_id','1')->where('usergroup_id','5')->first();

        $browser->visit('/admin/members')
                ->click('@show')
                ->pause(1000)
                ->select('#gender','male')
                ->pause(2000)
                ->click('@search-btn')
                ->pause(2000)
                ->click('#export-button')
                ->pause(5000)
                ->click('@show')
                ->pause(1000) 
                ->click('@reset-btn')
                ->pause(2000);

        });

    }

      /**
     * A Dusk test example.
     *@test
     * @return void
     */


    public function Exportbymembership()
    {
        $this->Login();

         $this->browse(function ($browser) {

            $searchuser=User::with('userprofile')->where('church_id','1')->where('usergroup_id','5')->first();

        $browser->visit('/admin/members')
                ->click('@show')
                ->pause(1000)
                ->select('#membership_type','member')
                ->pause(2000)
                ->click('@search-btn')
                ->pause(2000)
                ->click('#export-button')
                ->pause(5000)
                ->click('@show')
                ->pause(1000) 
                ->click('@reset-btn')
                ->pause(2000); 

        });

    }

      /**
     * A Dusk test example.
     *@test
     * @return void
     */

    public function marriage_status()
    {
        $this->Login();

         $this->browse(function ($browser) {

            $searchuser=User::with('userprofile')->where('church_id','1')->where('usergroup_id','5')->first();

        $browser->visit('/admin/members')
                ->click('@show')
                ->pause(1000)
                ->select('#marriage_status','married')
                ->pause(2000)
                ->click('@search-btn')
                ->pause(2000)
                ->click('#export-button')
                ->pause(5000)
                ->click('@show')
                ->pause(1000) 
                ->click('@reset-btn')
                ->pause(2000); 

        });

    }

      /**
     * A Dusk test example.
     *@test
     * @return void
     */


     public function baptism()
    {
        $this->Login();

        $this->browse(function ($browser) {

        $searchuser=User::with('userprofile')->where('church_id','1')->where('usergroup_id','5')->first();

        $browser->visit('/admin/members')
                ->click('@show')
                ->pause(1000)
                ->select('#baptism','yes')
                ->pause(2000)
                ->click('@search-btn')
                ->pause(2000)
                ->click('#export-button')
                ->pause(5000)
                ->click('@show')
                ->pause(1000) 
                ->click('@reset-btn')
                ->pause(2000); 

        });

    }

      /**
     * A Dusk test example.
     *@test
     * @return void
     */


   /* public function familyname()
    {
        $this->Login();

        $this->browse(function ($browser) {

        $searchuser=User::with('userprofile')->where('church_id','1')->where('usergroup_id','5')->first();

        $browser->visit('/admin/members')
                ->click('@show')
                ->pause(1000)
                ->type('#family',$searchuser->userprofile->family)
                ->pause(2000)
                ->click('@search-btn')
                ->pause(2000)
                ->click('#export-button')
                ->pause(10000)
                ->click('@show')
                ->pause(1000) 
                ->click('@reset-btn')
                ->pause(2000); 

        });

    }*/

      /**
     * A Dusk test example.
     *@test
     * @return void
     */



     public function profession()
    {
        $this->Login();

        $this->browse(function ($browser) {

        $searchuser=User::with('userprofile')->where('church_id','1')->where('usergroup_id','5')->first();

        $browser->visit('/admin/members')
                ->click('@show')
                ->pause(1000)
                ->select('#profession','business')
                ->pause(2000)
                ->click('@search-btn')
                ->pause(2000)
                ->click('#export-button')
                ->pause(5000)
                ->click('@show')
                ->pause(1000) 
                ->click('@reset-btn')
                ->pause(2000); 

        });

    }

      /**
     * A Dusk test example.
     *@test
     * @return void
     */


    public function Age()
    {
        $this->Login();

        $this->browse(function ($browser) {

        $searchuser=User::with('userprofile')->where('church_id','1')->where('usergroup_id','5')->first();

        $browser->visit('/admin/members')
                ->click('@show')
                ->pause(1000)
                ->select('#min_age','25')
                ->select('#max_age','40')
                ->pause(2000)
                ->click('@search-btn')
                ->pause(2000)
                ->click('#export-button')
                ->pause(5000)
                ->click('@show')
                ->pause(1000) 
                ->click('@reset-btn')
                ->pause(2000); 

        });

    }

      /**
     * A Dusk test example.
     *@test
     * @return void
     */

     public function mobile_no()
    {
        $this->Login();

        $this->browse(function ($browser) {

        $searchuser=User::with('userprofile')->where('church_id','1')->where('usergroup_id','5')->first();

        $browser->visit('/admin/members')
                ->click('@show')
                ->pause(1000)
                ->type('#mobile_no',$searchuser->mobile_no)
                ->pause(2000)
                ->click('@search-btn')
                ->pause(2000)
                ->click('#export-button')
                ->pause(5000)
                ->click('@show')
                ->pause(1000) 
                ->click('@reset-btn')
                ->pause(2000); 

        });

    }

      /**
     * A Dusk test example.
     *@test
     * @return void
     */

     public function email()
    {
        $this->Login();

        $this->browse(function ($browser) {

        $searchuser=User::with('userprofile')->where('church_id','1')->where('usergroup_id','5')->first();

        $browser->visit('/admin/members')
                ->click('@show')
                ->pause(1000)
                ->type('#email',$searchuser->email)
                ->pause(2000)
                ->click('@search-btn')
                ->pause(2000)
                ->click('#export-button')
                ->pause(5000)
                ->click('@show')
                ->pause(1000) 
                ->click('@reset-btn')
                ->pause(2000); 

        });

    }

      /**
     * A Dusk test example.
     *@test
     * @return void
     */


    public function location()
    {
        $this->Login();

        $this->browse(function ($browser) {

        $searchuser=User::with('userprofile')->where('church_id','1')->where('usergroup_id','5')->first();

        $browser->visit('/admin/members')
                ->click('@show')
                ->pause(1000)
                ->type('#location','7')
                ->pause(2000)
                ->click('@search-btn')
                ->pause(2000)
                ->click('#export-button')
                ->pause(5000)
                ->click('@show')
                ->pause(1000)  
                ->click('@reset-btn')
                ->pause(2000); 

        });

    }

      /**
     * A Dusk test example.
     *@test
     * @return void
     */

     public function date_of_birth()
    {
        $this->Login();

        $this->browse(function ($browser) {

        $searchuser=User::with('userprofile')->where('church_id','1')->where('usergroup_id','5')->first();

        $browser->visit('/admin/members')
                ->click('@show')
                ->pause(1000)
                ->select('#date_of_birth_after','05-11-1980')
                ->select('#date_of_birth_before','17-01-1995')
                ->pause(2000)
                ->click('@search-btn')
                ->pause(2000)
                ->click('#export-button')
                ->pause(5000)
                ->click('@show')
                ->pause(1000) 
                ->click('@reset-btn')
                ->pause(2000); 

        });

    }



}

