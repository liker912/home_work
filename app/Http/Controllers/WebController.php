<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class WebController extends Controller
{

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(): View
    {
        return view('home');
    }
}
