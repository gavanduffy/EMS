<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    /**
     * Display a the welcome page from the View File
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke()
    {
        return view('welcome');
        //return view('developer_version');
    }
}