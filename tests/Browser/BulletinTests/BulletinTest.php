<?php

use App\Models\User;
use Tests\DuskTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;


class BulletinTest extends DuskTestCase
{

    //use DatabaseMigrations;

    public function setUp() :void
    {
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
           $testuser =  User::where('usergroup_id', 3)->first();
            $browser->visit('/login')
                    ->type('#email', $testuser->email)
                    ->type('#password', 'password')
                    ->press('#login')
                    ->assertPathIs('/admin/dashboard');
        });
    }

    /**
     * A Dusk test example.
     * @test
     * @return void
     */

    public function Weekbulletin()
    {


        $this->Login();
       

        $this->browse(function ($browser) {

            $browser->visit('/admin/bulletin')
                    ->click('#upload-btn')
                    ->assertPathIs('/admin/bulletin/create')
                    ->type('#name','Test')
                    ->attach('#cover_image',__DIR__.'/../photos/photo.jpg')
                    ->pause(1000)
                    ->select('#type','week')
                    ->pause(2000)
                    ->select('#week','5')
                    ->select('#year','2018')
                    ->pause(2000)
                    ->attach('#path',__DIR__.'/../files/threemb.pdf')
                    ->pause(1000)
                    ->click('@submit-btn')
                    ->pause(2000)
                    ->assertSee('Bulletin Added Successfully')
                    ->pause(1000)
                    ->click('@profile-menu')
                    ->pause(2000)
                    ->click('@logout-link')
                    ->assertPathIs('/');

                });

    }

     /**
     * A Dusk test example.
     * @test
     * @return void
     */



     public function Monthbulletin()
    {


        $this->Login();
       

        $this->browse(function ($browser) {

            $browser->visit('/admin/bulletin')
                    ->click('#upload-btn')
                    ->assertPathIs('/admin/bulletin/create')
                    ->type('#name','Test')
                    ->attach('#cover_image',__DIR__.'/../photos/photo.jpg')
                    ->pause(1000)
                    ->select('#type','month')
                    ->pause(2000)
                    ->click('#month > option:nth-child(2)')
                    ->select('#year','2018')
                    ->attach('#path',__DIR__.'/../files/threemb.pdf')
                    ->pause(1000)
                    ->click('@submit-btn')
                    ->pause(2000)
                    ->assertSee('Bulletin Added Successfully')
                    ->pause(1000)
                    ->click('@profile-menu')
                    ->click('@logout-link')
                    ->assertPathIs('/');

                   

                });

    }


         /**
     * A Dusk test example.
     * @test
     * @return void
     */



     public function file_mismatch()
    {


        $this->Login();
       

        $this->browse(function ($browser) {

            $browser->visit('/admin/bulletin')
                    ->click('#upload-btn')
                    ->assertPathIs('/admin/bulletin/create')
                    ->type('#name','Test')
                    ->attach('#cover_image',__DIR__.'/../files/threemb.pdf')
                    ->pause(1000)
                    ->select('#type','month')
                    ->pause(2000)
                    ->click('#month > option:nth-child(2)')
                    ->select('#year','2018')
                    ->attach('#path',__DIR__.'/../photos/photo.jpg')
                    ->pause(1000)
                    ->click('@submit-btn')
                    ->pause(2000)
                    ->assertSee('Choose an image file')
                    ->assertSee('Choose a pdf file')
                    ->pause(1000);
                });

    } 


            /**
     * A Dusk test example.
     * @test
     * @return void
     */


      public function file_extension_error()
    {


        $this->Login();
       

        $this->browse(function ($browser) {

            $browser->visit('/admin/bulletin')
                    ->click('#upload-btn')
                    ->assertPathIs('/admin/bulletin/create')
                    ->type('#name','Test')
                    ->attach('#cover_image',__DIR__.'/../photos/photo.jpg')
                    ->pause(1000)
                    ->select('#type','month')
                    ->pause(2000)
                    ->click('#month > option:nth-child(2)')
                    ->select('#year','2018')
                    ->attach('#path',__DIR__.'/../files/tenmb.pdf')
                    ->pause(1000)
                    ->click('@submit-btn')
                    ->pause(2000)
                    ->assertSee('Maximum file size to upload is 8MB')
                    ->pause(1000);
                });

    }



}