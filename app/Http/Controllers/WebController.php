<?php

namespace App\Http\Controllers;

class WebController extends Controller
{

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function home()
    {
        return view('home');
    }
}
