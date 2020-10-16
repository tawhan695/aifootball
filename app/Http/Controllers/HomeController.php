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
        
       
        $league = DB::select('SELECT league FROM predict INNER JOIN link_match ON link_match.url= predict.url GROUP BY league');
        $date = DB::select('SELECT predict.date FROM predict INNER JOIN link_match ON link_match.url= predict.url GROUP BY predict.date');
        $accuracy = DB::select('SELECT * FROM accuracy ORDER BY accuracy.date DESC LIMIT 1');
        $accuracy2 = DB::select('SELECT * FROM accuracy ORDER BY accuracy.date DESC LIMIT 20');
        $predict = DB::select('SELECT * FROM predict INNER JOIN link_match ON link_match.url=predict.url where predict.predict = link_match.FTR ');
        $all = DB::select('SELECT * FROM predict INNER JOIN link_match ON link_match.url=predict.url where  link_match.FTR !=""');
       
        $percent = 0;
        if (count($all) != 0){

            $percent =  (count($predict) / count($all)) *100;
        }else{
            $percent = 0;
        }
        // รวมdate
        $date_arr =  array();
        for ($i=0; $i <count($date) ; $i++) { 
            if($i == 0){
                array_push($date_arr,$date[$i]->date);
            }
            for ($j=0; $j < count($date_arr) ; $j++) { 
                if($date[$i]->date != $date_arr[$j]){
                    array_push($date_arr,$date[$i]->date);
                }
            }
        }
        $last_date = count($date_arr)-1;
        $data = array();
        foreach ($league as $key => $value) {
            $sql = 'SELECT * FROM predict INNER JOIN link_match ON link_match.url=predict.url where link_match.league = "'.$value->league.'" and predict.date ="'.$date_arr[$last_date].'" ORDER BY link_match.time DESC';
        //    echo $sql;
            $le =  DB::select($sql);
            // var_dump($le);
            array_push($data,$le);
            
        }
        $list_date = array();
        for ($i=count($date_arr); $i > 0 ; $i--) { 
            // echo $i;
            if ((count($date_arr)-6 == $i )) {
            break;
            }
            array_push( $list_date,$date_arr[$i-1]);
            // echo $i;
            // echo $date_arr[$i-1];
        }
        // foreach ($date as $key => $dd) {
           
        // }
        // var_dump($list_date);
        session()->push('active',$date_arr[$last_date]);
        return view('home')->with(['Tablepredict'=> $data,'accuracy'=>$accuracy,'percent'=>$percent,'history'=> $accuracy2,'datelist' =>$list_date]);
    }
    public function date(Request $request){
        
        $league = DB::select('SELECT league FROM predict INNER JOIN link_match ON link_match.url= predict.url GROUP BY league');
        $date = DB::select('SELECT predict.date FROM predict INNER JOIN link_match ON link_match.url= predict.url GROUP BY predict.date');
        $accuracy = DB::select('SELECT * FROM accuracy ORDER BY accuracy.date DESC LIMIT 1');
        $accuracy2 = DB::select('SELECT * FROM accuracy ORDER BY accuracy.date DESC LIMIT 20');
        $predict = DB::select('SELECT * FROM predict INNER JOIN link_match ON link_match.url=predict.url where predict.predict = link_match.FTR ');
        $all = DB::select('SELECT * FROM predict INNER JOIN link_match ON link_match.url=predict.url where  link_match.FTR !=""');
        
        $percent = 0;
        if (count($all) != 0){
            
            $percent =  (count($predict) / count($all)) *100;
        }else{
            $percent = 0;
        }
        // รวมdate
        $date_arr =  array();
        for ($i=0; $i <count($date) ; $i++) { 
            if($i == 0){
                array_push($date_arr,$date[$i]->date);
            }
            for ($j=0; $j < count($date_arr) ; $j++) { 
                if($date[$i]->date != $date_arr[$j]){
                    array_push($date_arr,$date[$i]->date);
                }
            }
        }
        $last_date = $request->date;
        $data = array();
        foreach ($league as $key => $value) {
            $sql = 'SELECT * FROM predict INNER JOIN link_match ON link_match.url=predict.url where link_match.league = "'.$value->league.'" and predict.date ="'.$last_date.'" ORDER BY link_match.time DESC';
            //    echo $sql;
            $le =  DB::select($sql);
            // var_dump($le);
            array_push($data,$le);
            
        }
        $list_date = array();
        for ($i=count($date_arr); $i > 0 ; $i--) { 
            // echo $i;
            if ((count($date_arr)-6 == $i )) {
            break;
        }
        array_push( $list_date,$date_arr[$i-1]);
        // echo $i;
        // echo $date_arr[$i-1];
    }
    // foreach ($date as $key => $dd) {
        
        // }
        // var_dump($list_date);
        session()->push('active',$request->date);
        return view('home')->with(['Tablepredict'=> $data,'accuracy'=>$accuracy,'percent'=>$percent,'history'=> $accuracy2,'datelist' =>$list_date]);
    }
    
}
