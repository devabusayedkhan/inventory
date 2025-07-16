<?php

namespace App\Http\Controllers;

class AppController extends Controller
{
    function appLoader(){
        return view('pages.Home');
    }


    function NotFount404(){
        return view('pages.404.NotFount404');
    }
}
