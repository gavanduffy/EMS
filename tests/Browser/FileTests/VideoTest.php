<?php

use App\Models\User;
use Tests\DuskTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class VideoTest extends DuskTestCase
{
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
    public function AddVideoSuccess()
    {
        $this->AdminLogin();

        $this->browse(function ($browser) {
            $testuser = User::find(2);
            $edituser = User::with('userprofile')->where('church_id','1')->where('usergroup_id','5')->first();
            $email = $edituser->email;
            $name = $edituser->name;
            $firstname = $edituser->userprofile->firstname;

            $browser->visit('/admin/videos')
                    ->pause(2000)
                    ->type('#name','Video')
                    ->type('#description','Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.')
                    ->type('#video','https://www.youtube.com/watch?v=EngW7tLk6R8')
                    ->pause(2000)
                    ->click('#submit')
                    ->pause(5000)
                    ->assertSee('Videos Added Successfully')
                    ->pause(5000)
                    ->click('@video')
                    ->pause(7000)
                    ->visit('/admin/videos')
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
    public function AddVideoFailure()
    {
        $this->AdminLogin();

        $this->browse(function ($browser) {
            $testuser = User::find(2);
            $edituser = User::with('userprofile')->where('church_id','1')->where('usergroup_id','5')->first();
            $email = $edituser->email;
            $name = $edituser->name;
            $firstname = $edituser->userprofile->firstname;

            $browser->visit('/admin/videos')
                    ->pause(2000)
                    ->type('#name','Video')
                    ->type('#description','Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.')
                    ->pause(2000)
                    ->click('#submit')
                    ->pause(5000)
                    ->assertSee('Enter your video url')
                    ->pause(5000)
                    ->click('@profile-menu')
                    ->assertSee($testuser->email)
                    ->click('@logout-link')
                    ->assertPathIs('/');
        });          
    } 
}