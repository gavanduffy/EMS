<?php

use App\Models\User;
use Tests\DuskTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class SiteAdminLoginTest extends DuskTestCase
{

    use DatabaseMigrations;

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
    public function SiteAdminLogin()
    {

        $this->browse(function ($browser) {
            $browser->visit('/login')
                    ->type('#email', 'siteadmin@church.com')
                    ->type('#password', 'password')
                    ->press('#login')           
                    ->assertPathIs('/portal/dashboards/main');
                 
        });
    }

    /**
     * A Dusk test example.
     * @test
     * @return void
    */
    public function SiteAdminLogout()
    {
        $this->browse(function ($browser) {
            $browser->click('@profile-menu')
                    ->click('#logout')
                    ->assertPathIs('/');
        });
    }

}