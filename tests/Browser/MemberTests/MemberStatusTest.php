<?php

use App\Models\User;
use Tests\DuskTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class MemberStatusTest extends DuskTestCase
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
    public function ChangeMemberStatus()
    {
        $this->AdminLogin();

        $this->browse(function ($browser) {
            $testuser = User::find(2);
            $edituser = User::with('userprofile')->where('church_id','1')->where('usergroup_id','5')->first();
            $email = $edituser->email;
            $name = $edituser->name;
            $firstname = $edituser->userprofile->firstname;

            $browser->click('#app > div.flex.flex-col.lg\:flex-row.md\:flex-row.min-h-full > div.w-full.lg\:w-40.md\:w-40.admin-sidebar > div > ul > li:nth-child(2) > a > span')
                    ->assertPathIs('/admin/members')
                    ->pause(2000)
                    ->click('#app > div.flex.flex-col.lg\:flex-row.md\:flex-row.min-h-full.relative > div.w-full.px-5.py-3 > main > div > div:nth-child(3) > div:nth-child(2) > div.my-8 > div > div:nth-child(1) > div > div')
                    ->pause(5000)
                    ->click('#show-detail > div > div > div.w-full.lg\:w-4\/5.md\:w-4\/5.px-3.lg\:px-0.md\:px-0 > div.pt-3.border-t > a > span')
                    ->pause(2000)
                    ->assertPathIs('/admin/member/show/'.$name)
                    ->click('#status')
                    ->pause(2000)
                    ->assertSee('Do you want to change the status ?')
                    ->click(' > div.swal-overlay.swal-overlay--show-modal > div > div.swal-footer > div:nth-child(2) > button')
                    ->pause(2000)
                    ->click(' > div.swal-overlay.swal-overlay--show-modal > div > div.swal-footer > div > button')
                    ->pause(2000)
                    ->assertPathIs('/admin/member/show/'.$name)
                    ->pause(5000)
                    ->click('@profile-menu')
                    ->assertSee($testuser->email)
                    ->click('@logout-link')
                    ->assertPathIs('/')
                    ->visit('/login')
                    ->type('#email', $email)
                    ->type('#password', 'password')
                    ->pause(2000)
                    ->press('#login')  
                    ->pause(3000)        
                    ->assertSee('You are suspended by site admin');
        });          
    } 

    /**
     * A Dusk test example.
     * @test
     * @return void
     */
    public function MemberLogin()
    {
        
        $this->browse(function ($browser) {
            
            $testuser = User::where('usergroup_id', 5)->first();

            $browser->visit('/login')
                    ->type('#email', $testuser->email)
                    ->type('#password', 'password')
                    ->press('#login')           
                    ->assertPathIs('/admin/dashboard');
        });
    }

    /**
     * A Dusk test example.
     *@test
     * @return void
     */
    public function VerifyMember()
    {
        $this->AdminLogin();

        $this->browse(function ($browser) {
            $testuser = User::find(2);
            $edituser = User::with('userprofile')->where('church_id','1')->where('usergroup_id','5')->first();
            $email = $edituser->email;
            $name = $edituser->name;
            $firstname = $edituser->userprofile->firstname;

            $browser->click('#app > div.flex.flex-col.lg\:flex-row.md\:flex-row.min-h-full > div.w-full.lg\:w-40.md\:w-40.admin-sidebar > div > ul > li:nth-child(2) > a > span')
                    ->assertPathIs('/admin/members')
                    ->pause(2000)
                    ->click('#app > div.flex.flex-col.lg\:flex-row.md\:flex-row.min-h-full.relative > div.w-full.px-5.py-3 > main > div > div:nth-child(3) > div:nth-child(2) > div.my-8 > div > div:nth-child(1) > div > div')
                    ->pause(5000)
                    ->click('#show-detail > div > div > div.w-full.lg\:w-4\/5.md\:w-4\/5.px-3.lg\:px-0.md\:px-0 > div.pt-3.border-t > a > span')
                    ->pause(2000)
                    ->assertPathIs('/admin/member/show/'.$name)
                    ->click('#verify_mail')
                    ->pause(2000)
                    ->assertSee('Do you want to verify email for this member ?')
                    ->click(' > div.swal-overlay.swal-overlay--show-modal > div > div.swal-footer > div:nth-child(2) > button')
                    ->pause(5000)
                    ->assertSee('Verification code sent Successfully')
                    ->click(' > div.swal-overlay.swal-overlay--show-modal > div > div.swal-footer > div > button')
                    ->pause(2000)
                    ->assertPathIs('/admin/member/show/'.$name)
                    ->pause(5000)
                    ->visit('/emailverification/'.$edituser->email_verification_code)
                    ->pause(10000)
                    ->visit('/admin/member/show/'.$name)
                    ->pause(5000);
        });          
    } 
}