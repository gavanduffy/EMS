 <?php

use App\Models\User;
use Tests\DuskTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;


class DetailTest extends DuskTestCase
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




 public function Detail_edit()
    {
         $this->Login();
       

        $this->browse(function ($browser) {

            $browser->visit('/admin/events')
                    ->pause(2000)
                    ->mouseover('#eve1')
                    ->pause(2000)
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
