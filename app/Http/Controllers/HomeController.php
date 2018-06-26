<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\App;
use Illuminate\Http\Response;

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
        $lang = (App::getLocale() === "zh-cmn-Hant") ? "name_t as name" : "name";
        $list = DB::table('pm_subcategory')->where("status", 1)->orderBy("releaseDate", "desc")->select('symbol', 'releaseDate', $lang, 'series')->get();
        return view('home', [ 'list' => $list ]);
    }

    public function download()
    {
        return view('download');
    }

    public function siteMap()
    {
        $posts = DB::table("pm_card")->leftJoin('pm_subcategory', 'pm_card.subcategory', '=', 'pm_subcategory.id')->select('pm_card.img', 'pm_subcategory.releaseDate')->get();
        return response()->view('sitemap', [
            'posts' => $posts,
        ])->header('Content-Type', 'text/xml');
    }

    public function lang(Request $request){
        $data = $request->all();
        App::setLocale($data['language']);
        $res = $request->session()->put('language',$data['language']);           
        $json = array('lang' => App::getLocale());
        return response()->json($json);
    }
}
