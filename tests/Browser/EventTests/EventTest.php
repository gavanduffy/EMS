<?php

use App\Models\User;
use Tests\DuskTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;


class EventTest extends DuskTestCase
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

    public function AddEvent()
    {

        $this->Login();
       

        $this->browse(function ($browser) {

            $browser->visit('/admin/events')
                    ->click('#show')
                    ->click('#private');

            $browser->whenAvailable('.modal-container', function ($modal) {
                $modal->assertSee('Add Event')
                      ->click('#close-button'); 
            })->waitUntilMissing('.modal-container')
                    ->assertDontSee('Add Event');

            $browser->visit('admin/events')
                   ->click('#show')
                    ->click('#public');

            $browser->whenAvailable('.modal-container', function ($modal) {
                $modal->assertSee('Add Event')
                    ->type('#title','my test prayer two')
                    ->type('#description','prayer session')
                    ->radio('#repeats','no')
                    ->type('#location','chennai')
                    ->select('#category','prayer')
                    ->attach('#image', __DIR__.'/../photos/photo.jpg')
                    ->pause(1000)
                    ->click('#start_date')
                    ->pause(1000)
                    ->click('#start_date > div > div > div:nth-child(1) > div:nth-child(3) > div:nth-child(3) > span:nth-child(5)')
                    ->click(' #start_date > div > div > button:nth-child(4)')
                    ->pause(1000)
                    ->click('#end_date')
                    ->pause(1000)      
                    ->click('#end_date > div > div > div:nth-child(1) > div:nth-child(3) > div:nth-child(3) > span:nth-child(6)')
                    ->pause(1000)
                    ->click('#end_date > div > div > button:nth-child(4)') 
                    ->pause(1000)
                    ->click('@submit-btn')
                    ->pause(5000);
                   
                    
                });
                  
                       
        });

       $this->assertDatabaseHas('events', [
            'title' => 'my test prayer two'
        ]);

        $this->browse(function ($browser) {
            $browser->visit('/admin/events')
                    ->assertSee('Events (3)');
        });


   
    }

      /**
     * A Dusk test example.
     * @test
     * @return void
     */


    public function RecurringEvent()
    {

        $this->Login();
       

        $this->browse(function ($browser) {

            $browser->visit('/admin/events')
                    ->click('#show')
                    ->click('#private');


            $browser->whenAvailable('.modal-container', function ($modal) {
                $modal->assertSee('Add Event')
                      ->click('#close-button'); 
            })->waitUntilMissing('.modal-container')
                    ->assertDontSee('Add Event');

            $browser->visit('/admin/events')
                   ->click('#show')
                    ->click('#public');


            $browser->whenAvailable('.modal-container', function ($modal) {
                $modal->assertSee('Add Event')
                    ->type('#title','my test prayer two')
                    ->type('#description','prayer session')
                    ->click('#repeat','yes')
                    ->pause(3000)
                    ->type('freq','1')
                    ->pause(3000)
                    ->select('#freq_term','week')
                    ->type('#location','chennai')
                    ->select('#category','prayer')
                    ->attach('#image', __DIR__.'/../photos/photo.jpg')
                    ->pause(1000)
                    ->click('#start_date')
                    ->pause(1000)
                    ->click('#start_date > div > div > div:nth-child(1) > div:nth-child(3) > div:nth-child(3) > span:nth-child(7)')
                    ->click(' #start_date > div > div > button:nth-child(4)')
                    ->pause(1000)
                    ->click('#end_date')
                    ->pause(1000)      
                    ->click('#end_date > div > div > div:nth-child(1) > div:nth-child(3) > div:nth-child(4) > span:nth-child(7)')
                    ->pause(1000)
                    ->click('#end_date > div > div > button:nth-child(4)') 
                    ->pause(1000)
                    ->click('@submit-btn')
                    ->pause(5000);
                   
                    
                });
                       
        });

       $this->assertDatabaseHas('events', [
            'title' => 'my test prayer two'
        ]);

        $this->browse(function ($browser) {
            $browser->visit('/admin/events')
                    ->pause(2000)
                    ->assertSee('Events (3)');
        });


   
    }

       /**
     * A Dusk test example.
     * @test
     * @return void
     */

    public function Edit()
    {
         $this->Login();
       

        $this->browse(function ($browser) {

            $browser->visit('/admin/events')
                    ->pause(2000)
                    ->click('#eve1')
                    ->pause(1000)
                    ->type('#title','my test prayer two')
                    ->type('#description','prayer session')
                    ->radio('#repeats','no')
                    ->type('#location','Madurai')
                    ->select('#category','prayer')
                    ->attach('#image', __DIR__.'/../photos/photo.jpg')
                    ->pause(1000)
                    ->click('#start_date')
                    ->pause(1000)
                    ->click('#start_date > div > div > div:nth-child(1) > div:nth-child(3) > div:nth-child(3) > span:nth-child(5)')
                    ->click(' #start_date > div > div > button:nth-child(4)')
                    ->pause(1000)
                    ->click('#end_date')
                    ->pause(1000)      
                    ->click('#end_date > div > div > div:nth-child(1) > div:nth-child(3) > div:nth-child(3) > span:nth-child(6)')
                    ->pause(1000)
                    ->click('#end_date > div > div > button:nth-child(4)') 
                    ->pause(1000)
                    ->click('@update-btn')
                    ->pause(1000)
                    ->assertSee('Events Updated Successfully');
                });




    }


           /**
     * A Dusk test example.
     * @test
     * @return void
     */

    public function Failure_Edit()
    {
         $this->Login();
       

        $this->browse(function ($browser) {

            $browser->visit('/admin/events')
                    ->pause(2000)
                    ->click('#eve1')
                    ->pause(1000)
                    ->type('#title','my test prayer two')
                    ->type('#description','prayer session')
                    ->radio('#repeats','no')
                    ->type('#location','Madurai')
                    ->select('#category','prayer')
                    ->attach('#image', __DIR__.'/../photos/photo.jpg')
                    ->pause(5000)
                    ->click('#start_date')
                    ->pause(5000)
                    ->click('#start_date > div > div > div:nth-child(1) > div:nth-child(3) > div:nth-child(3) > span:nth-child(2)')
                    ->click('#start_date > div > div > button:nth-child(4)')
                    ->pause(5000)
                    ->click('#end_date')
                    ->pause(5000)      
                    ->click('#end_date > div > div > div:nth-child(1) > div:nth-child(3) > div:nth-child(3) > span:nth-child(5)')
                    ->pause(5000)
                    ->click('#end_date > div > div > button:nth-child(4)') 
                    ->pause(5000)
                    ->click('@update-btn')
                    ->pause(10000)
                    ->assertSee('The start date must be a date after yesterday.');
                   
                });




    }



       /**
     * A Dusk test example.
     * @test
     * @return void
     */



    public function Detail_edit()
    {
         $this->Login();
       

        $this->browse(function ($browser) {

            $browser->visit('/admin/events')
                    ->pause(2000)
                    ->mouseover('#eve1')
                    ->pause(1000)
                    ->click('@detail-btn')
                    ->pause(1000)
                    ->visit('/admin/events/show/details/1')
                    ->pause(1000)
                    ->click('#edit')
                    ->pause(1000)
                    ->type('#title','my test prayer two')
                    ->type('#description','prayer session')
                    ->radio('#repeats','no')
                    ->type('#location','Madurai')
                    ->select('#category','prayer')
                    ->attach('#image', __DIR__.'/../photos/photo.jpg')
                    ->pause(2000)
                    ->click('#start_date')
                    ->pause(1000)
                    ->click('#start_date > div > div > div:nth-child(1) > div:nth-child(3) > div:nth-child(3) > span:nth-child(4)')
                    ->click(' #start_date > div > div > button:nth-child(4)')
                    ->pause(1000)
                    ->click('#end_date')
                    ->pause(1000)      
                    ->click('#end_date > div > div > div:nth-child(1) > div:nth-child(3) > div:nth-child(3) > span:nth-child(5)')
                    ->pause(1000)
                    ->click('#end_date > div > div > button:nth-child(4)') 
                    ->pause(1000)
                    ->click('@update-btn')
                    ->pause(1000)
                    ->assertSee('Events Updated Successfully');

         });


    }

         /**
     * A Dusk test example.
     * @test
     * @return void
     */

    public function photos()
    {
         $this->Login();
       

        $this->browse(function ($browser) {

             //$event = Event::find(1);

              $browser->visit('/admin/events')
                    ->pause(1000)
                    ->mouseover('#eve1')
                    ->pause(1000)
                    ->click('@detail-btn')
                    ->pause(1000)
                    ->visit('/admin/events/show/details/1')
                    ->pause(1000)
                    ->assertSee('Description')
                    ->click('#photos')
                    ->click('#select')
                    ->pause(2000)
                    ->attach('image-upload', __DIR__.'/../photos/photo.jpg')
                    ->pause(2000)
                    ->attach('image-upload',__DIR__.'/../photos/image_4.jpg')
                    ->pause(5000)
                    ->click('#submit')
                    ->pause(5000)
                    ->assertSee('Uploaded Successfully')
                    ->pause(3000);


        });


    }



                 /**
     * A Dusk test example.
     * @test
     * @return void
     */

    public function notes()
    {
         $this->Login();
       

        $this->browse(function ($browser) {

             //$event = Event::find(1);

              $browser->visit('/admin/events')
                    ->pause(1000)
                    ->mouseover('#eve1')
                    ->pause(1000)
                    ->click('@detail-btn')
                    ->pause(1000)
                    ->visit('/admin/events/show/details/1')
                    ->pause(1000)
                    ->assertSee('Description')
                    ->click('#notes')
                    ->pause(1000)
                    ->type('#app > div.flex.flex-col.lg\:flex-row.md\:flex-row.min-h-full.relative > div.w-full.px-5.py-3 > main > div:nth-child(1) > div.bg-white.shadow.my-5 > div.vue-portal-target > div.px-3.overflow-x-scroll.lg\:overflow-x-auto.md\:overflow-x-auto.py-3.block > div > div > div.w-1\/2.mx-4 > div.form-group > textarea','test')
                    ->pause(1000)
                    ->click('#app > div.flex.flex-col.lg\:flex-row.md\:flex-row.min-h-full.relative > div.w-full.px-5.py-3 > main > div:nth-child(1) > div.bg-white.shadow.my-5 > div.vue-portal-target > div.px-3.overflow-x-scroll.lg\:overflow-x-auto.md\:overflow-x-auto.py-3.block > div > div > div.w-1\/2.mx-4 > div.my-6 > div > a')
                    ->pause(1000)
                    ->assertSee('Saved successfully.')
                    ->pause(1000);


        });


    }





         /**
     * A Dusk test example.
     * @test
     * @return void
     */

//Failure Test Cases

    public function description_exceed()
    {

              $this->Login();
       

        $this->browse(function ($browser) {

            $browser->visit('/admin/events')
                    ->click('#show')
                    ->click('#private');


            $browser->whenAvailable('.modal-container', function ($modal) {
                $modal->assertSee('Add Event')
                      ->click('#close-button'); 
            })->waitUntilMissing('.modal-container')
                    ->assertDontSee('Add Event');

            $browser->visit('admin/events')
                   ->click('#show')
                    ->click('#public');


            $browser->whenAvailable('.modal-container', function ($modal) {
                $modal->assertSee('Add Event')
                    ->type('#title','my test prayer 2')
                    ->type('#description','Coming back to the imported class. That is a class that you can use which is by default imported and not used. It just showing that you can use it in your tests. See the documentation for more info on that')
                    ->radio('#repeats','no')
                    ->type('#location','chennai')
                    ->select('#category','prayer')
                    ->attach('#image', __DIR__.'/../photos/photo.jpg')
                    ->pause(1000)
                    ->click('#start_date')
                    ->pause(1000)
                    ->click('#start_date > div > div > div:nth-child(1) > div:nth-child(3) > div:nth-child(3) > span:nth-child(4)')
                    ->click(' #start_date > div > div > button:nth-child(4)')
                    ->pause(1000)
                    ->click('#end_date')
                    ->pause(1000)      
                    ->click('#end_date > div > div > div:nth-child(1) > div:nth-child(3) > div:nth-child(3) > span:nth-child(5)')
                    ->pause(1000)
                    ->click('#end_date > div > div > button:nth-child(4)') 
                    ->pause(1000)
                    ->click('@submit-btn')
                    ->pause(5000)
                    ->assertSee('Enter only alphabets')
                    ->assertSee('The description may not be greater than 100 characters.');
                   
                    
                });
                  
                       
        });

   /*    $this->assertDatabaseHas('events', [
            'title' => 'my test prayer two'
        ]);

        $this->browse(function ($browser) {
            $browser->visit('/admin/events')
                    ->assertSee('Events (3)');
        });
*/


        
    }



         /**
     * A Dusk test example.
     * @test
     * @return void
     */

    public function repeat_error()

    {

            $this->Login();
       

        $this->browse(function ($browser) {

            $browser->visit('/admin/events')
                    ->click('#show')
                    ->click('#private');


            $browser->whenAvailable('.modal-container', function ($modal) {
                $modal->assertSee('Add Event')
                      ->click('#close-button'); 
            })->waitUntilMissing('.modal-container')
                    ->assertDontSee('Add Event');

            $browser->visit('admin/events')
                    ->click('#show')
                    ->click('#public');


            $browser->whenAvailable('.modal-container', function ($modal) {
                $modal->assertSee('Add Event')
                    ->type('#title','my test prayer two')
                    ->type('#description','Prayer Session')
                    ->radio('#repeat','yes')
                    ->type('#location','chennai')
                    ->select('#category','prayer')
                    ->attach('#image', __DIR__.'/../photos/photo.jpg')
                    ->pause(1000)
                    ->click('#start_date')
                    ->pause(1000)
                    ->click('#start_date > div > div > div:nth-child(1) > div:nth-child(3) > div:nth-child(3) > span:nth-child(4)')
                    ->click(' #start_date > div > div > button:nth-child(4)')
                    ->pause(1000)
                    ->click('#end_date')
                    ->pause(1000)      
                    ->click('#end_date > div > div > div:nth-child(1) > div:nth-child(3) > div:nth-child(3) > span:nth-child(5)')
                    ->pause(1000)
                    ->click('#end_date > div > div > button:nth-child(4)') 
                    ->pause(1000)
                    ->click('@submit-btn')
                    ->pause(5000)
                    ->assertSee('Select freq')
                    ->assertSee('Select freq term');
                   
                    
                });
                  
                       
        });
    }

          /**
     * A Dusk test example.
     * @test
     * @return void
     */

    public function date_mismatch()

    {

            $this->Login();
       

        $this->browse(function ($browser) {

            $browser->visit('/admin/events')
                    ->click('#show')
                    ->click('#private');


            $browser->whenAvailable('.modal-container', function ($modal) {
                $modal->assertSee('Add Event')
                      ->click('#close-button'); 
            })->waitUntilMissing('.modal-container')
                    ->assertDontSee('Add Event');

            $browser->visit('admin/events')
                    ->click('#show')
                    ->click('#public');


            $browser->whenAvailable('.modal-container', function ($modal) {
                $modal->assertSee('Add Event')
                    ->type('#title','my test prayer two')
                    ->type('#description','Prayer Session')
                    ->radio('#repeats','no')
                    ->type('#location','chennai')
                    ->select('#category','prayer')
                    ->attach('#image', __DIR__.'/../photos/photo.jpg')
                    ->pause(1000)
                    ->click('#start_date')
                    ->pause(1000)
                    ->click('#start_date > div > div > div:nth-child(1) > div:nth-child(3) > div:nth-child(3) > span:nth-child(3)')
                    ->click(' #start_date > div > div > button:nth-child(4)')
                    ->pause(1000)
                    ->click('#end_date')
                    ->pause(1000)      
                    ->click('#end_date > div > div > div:nth-child(1) > div:nth-child(3) > div:nth-child(3) > span:nth-child(5)')
                    ->pause(1000)
                    ->click('#end_date > div > div > button:nth-child(4)') 
                    ->pause(1000)
                    ->click('@submit-btn')
                    ->pause(5000)
                    ->assertSee('Please select upcoming date');
                   
                   
                    
                });
                  
                       
        });
    }



       /**
     * A Dusk test example.
     * @test
     * @return void
     */

    public function Detail_edit_error()
    {
         $this->Login();
       

        $this->browse(function ($browser) {

            $browser->visit('/admin/events')
                    ->mouseover('#eve1')
                    ->pause(1000)
                    ->click('@detail-btn')
                    ->pause(1000)
                    ->visit('/admin/events/show/details/1')
                    ->pause(1000)
                    ->click('#edit')
                    ->pause(1000)
                    ->type('#title','my test prayer two')
                    ->type('#description','prayer session')
                    ->radio('#repeats','no')
                    ->type('#location','Madurai')
                    ->select('#category','prayer')
                    ->attach('#image', __DIR__.'/../photos/photo.jpg')
                    ->pause(5000)
                    ->click('#start_date')
                    ->pause(5000)
                    ->click('#start_date > div > div > div:nth-child(1) > div:nth-child(3) > div:nth-child(3) > span:nth-child(5)')
                    ->click(' #start_date > div > div > button:nth-child(4)')
                    ->pause(5000)
                    ->click('#end_date')
                    ->pause(5000)      
                    ->click('#end_date > div > div > div:nth-child(1) > div:nth-child(3) > div:nth-child(3) > span:nth-child(3)')
                    ->pause(5000)
                    ->click('#end_date > div > div > button:nth-child(4)') 
                    ->pause(5000)
                    ->click('@update-btn')
                    ->pause(5000)
                    ->assertSee('The start date must be a date before end date.')
                    ->assertSee('The end date must be a date after or equal to start date.');

         });


    }







}


