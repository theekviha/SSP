<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class ItemController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        session()->flash('notification', 'Welcome to the home page');
        return view('home');
    }
}
