<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $list = DB::table('pm_subcategory')->where("status", 1)->orderBy("releaseDate", "desc")->get();
        //dump($list);
        return view('home', [ 'list' => $list ]);
    }
}
