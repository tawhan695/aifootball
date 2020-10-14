<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\accuracy;
use App\link_match;
use App\predict;
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
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {   
        
        $data = array();
        $league = DB::select('SELECT league FROM predict INNER JOIN link_match ON link_match.url= predict.url GROUP BY league');
        foreach ($league as $key => $value) {
            array_push($data,DB::select('SELECT * FROM predict INNER JOIN link_match ON link_match.url=predict.url where league = "'.$value->league.'" ORDER BY link_match.time DESC'));
            
        }
        // var_dump($data);
        return view('home')->with(['Tablepredict'=> $data]);
    }
}
