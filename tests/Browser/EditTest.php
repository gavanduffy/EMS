<?php

use App\Models\User;
use Tests\DuskTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class EditTest extends DuskTestCase
{

    //use DatabaseMigrations;
    /**
     * A Dusk test example.
     *
     * @return void
     */

    public function test_edit_event()
    {

        $this->browse(function ($browser) {
             $browser->visit('/login')
                    ->type('#email', 'bmueller@example.org')
                    ->type('#password', 'password')
                    ->press('#login')           
                    ->assertPathIs('/admin/dashboard')
                    ->visit('admin/events')
                    ->pause(500)
                    ->type('#event_id','11')
                    ->value('#title','prayer')
                    ->value('#description','prayer session')
                    ->radio('#repeats','no')
                    ->value('#location','chennai')
                    ->value('#category','prayer')
                    ->value('#image', __DIR__.'/photos/photo.jpg')
                    ->value('#start_date','01-11-2019 01:17:00')       
                    ->value('#end_date','05-11-2019 05:00:PM')
                    ->press('#submit')
                    ->visit('/logout');
                   // ->assertSee('Event Created')
                   // ->assertPathIs('admin/events');
                   
        });
    }



}