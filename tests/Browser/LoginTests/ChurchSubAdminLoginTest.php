<?php

use App\Models\User;
use Tests\DuskTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ChurchSubAdminLoginTest extends DuskTestCase
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
            
            $testuser = User::where('usergroup_id', 4)->first();

            $browser->visit('/login')
                    ->type('#email', $testuser->email)
                    ->type('#password', 'password')
                    ->press('#login')           
                     ->assertPathIs('/admin/dashboard')
                    ->click('@profile-menu')
                    ->assertSee($testuser->email)
                    ->click('@logout-link')
                    ->assertPathIs('/');
        });
    }

}