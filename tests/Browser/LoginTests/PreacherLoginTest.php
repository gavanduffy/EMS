<?php

use App\Models\User;
use Tests\DuskTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class PreacherLoginTest extends DuskTestCase
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

    public function PreacherLogin()
    {


        $this->browse(function ($browser) {
            
            $testpreacher = User::where('usergroup_id', 6)->first();

            $browser->visit('/login')
                    ->type('#email', $testpreacher->email)
                    ->type('#password', 'password')
                    ->press('#login')           
                    ->assertPathIs('/preacher/dashboard')
                    ->assertSee('ChurchCMS-Dusk-Test')
                    ->click('@profile-menu')
                    ->assertSee($testpreacher->email)
                    ->click('@logout-link')
                    ->assertPathIs('/');
        });
    }

   /* public function testPreacherEmail()
    {

        $this->browse(function ($browser) {
            $browser->visit('/login')
                    ->type('#email', 'john@church.com')
                    ->type('#password', 'password')
                    ->press('#login')           
                    ->assertSee('Invalid Credential');
        });
    }

    
    public function testPreacherPassword()
    {

        $this->browse(function ($browser) {
            $browser->visit('/login')
                    ->type('#email', 'udouglas@example.net')
                    ->type('#password', 'secret')
                    ->press('#login')           
                    ->assertSee('Invalid Credential');
        });
    }*/
}