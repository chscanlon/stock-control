<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StocktakeItemController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
}
