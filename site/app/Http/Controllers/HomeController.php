<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\VisitorModel;
use App\ServicesModel;
use App\CourseModel;
class HomeController extends Controller
{
    function HomeIndex(){
        //visitor table data operation
        $UserIP=$_SERVER['REMOTE_ADDR'];
        date_default_timezone_set("Asia/Dhaka");
        $timeDate= date("Y-m-d h:i:sa");
        VisitorModel::insert(['ip_address'=>$UserIP, 'visit_time'=>$timeDate]);

        //services table data operation
        $ServicesData = json_decode( ServicesModel::all() );
        $CourseData = json_decode(CourseModel::orderby('id','desc')->limit(6)->get()); //last theke 6 ta data nilam home page e show korar jonno



        return view('Home', [
            'ServicesData'=> $ServicesData,
            'CourseData'=>$CourseData]);
    }


}
