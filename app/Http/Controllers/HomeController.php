<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function admin(Request $request){
      // return $path = url('/')."/admin/dashboard";
        //return redirect($path);
        $path=route('login');

        return redirect($path)->with('status', 'Welcome to the admin panel!');
    }
}
