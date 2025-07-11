<?php

use App\Models\User;
use Tests\DuskTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ChurchAdminLoginTest extends DuskTestCase
{

    //use DatabaseMigrations;

    public function setUp() :void
    {
        //dd(env('DB_DATABASE'));
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
//dump($testuser);
            $browser->visit('/login')
                    ->type('#email', $testuser->email)
                    ->type('#password', 'password')
                    ->press('#login') 
                    ->pause(2000)          
                    ->assertPathIs('/admin/dashboard')
                    ->click('@profile-menu')
                    ->assertSee($testuser->email)
                    ->click('@logout-link')
                    ->assertPathIs('/');
        });
    }

}