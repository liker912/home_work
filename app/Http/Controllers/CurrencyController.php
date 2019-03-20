<?php

namespace App\Http\Controllers;

use App\Events\CurrencySent;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{

    public function index()
    {

        event(new CurrencySent("TESTTTT"));
        return view('home');
    }
}
