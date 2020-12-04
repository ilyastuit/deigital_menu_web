<?php

namespace App\Http\Controllers;

class HomeController extends Controller
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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {

        if(auth()->user()->hasRole('owner')){
            return redirect()->route('admin.restaurants.edit',  auth()->user()->restorant->id);
        } else if(auth()->user()->hasRole('admin')){
            return redirect()->route('admin.restaurants.index');
        }

    }
}
