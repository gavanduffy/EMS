<?php

use App\Models\User;
use Tests\DuskTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ChangePasswordTest extends DuskTestCase
{

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
    public function passwordChange()
    {
          //var_dump(env('DB_DATABASE'));


        $this->browse(function ($browser) {
          
            $testuser = User::find(2);

            $browser->visit('/login')
                    ->type('#email', $testuser->email)
                    ->type('#password', 'password')
                    ->press('#login')           
                    ->assertPathIs('/admin/dashboard');

            $browser->click('@profile-menu')
                    ->assertSee($testuser->email)
                    ->click('@password-link')
                    ->visit('/admin/changepassword')
                    ->assertPathIs('/admin/changepassword')
                    ->pause(2000)
                    ->type('oldpassword','password')
                    ->type('newpassword','secretone')
                    ->type('confirmpassword','secretone')
                    ->click('@submit-button')
                    ->click('@profile-menu')
                    ->assertSee($testuser->email)
                    ->click('@logout-link')
                    ->assertPathIs('/')
                    ->visit('/login')
                    ->type('#email',$testuser->email)
                    ->type('#password','secretone')
                    ->press('#login')
                    ->assertPathIs('/admin/dashboard')
                    ->click('@profile-menu')
                    ->assertSee($testuser->email)
                    ->click('@logout-link')
                    ->assertPathIs('/');
        });
    }

}