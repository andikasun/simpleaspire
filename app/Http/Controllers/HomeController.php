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
        $this->middleware('auth');
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
    public function applyloan(Request $request) {
        return view('loanapplication');
    }
    public function loandetail($id)
    {
        return view('loandetail', ["loan_id"=>$id]);
    }
    public function payloan($id)
    {
        return view('loandetail', ["loan_id"=>$id]);
    }
}
