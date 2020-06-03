<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CourseModel;

class CoursesController extends Controller
{
    //course section; course view
     function CoursesIndex(){
     	
		return view('Courses');
    }

    //course section; get all data from database and send to script section in getCourseJsonData function
	function getCoursesData(){
		$allCourseData = json_encode(CourseModel::all());
		return $allCourseData;
    }

    //course section; get all details [all coloumns] of each data for edit service
    function getCoursesDetailsData(Request $request){
    	$editId = $request->input('id');
    	$editQuery = json_encode(CourseModel::where('id','=',$editId)->get()) ;
    	return $editQuery;

    }

    //course section; course delete function
	function CoursesDelete(Request $request){
    	$deleteId = $request->input('id');
    	$deleteQuery = CourseModel::where('id','=',$deleteId)->delete();
    	if($deleteQuery == true)
    	{
    		return 1;
		}
    	else
    	{
    		return 0;
    	}
    }
	//course section; course update function
    function CoursesUpdate(Request $request){ 
    	$updateId = $request->input('id');
    	$name = $request->input('name');
    	$des = $request->input('des');
    	$fee = $request->input('fee');
    	$totalEnrolled = $request->input('enrolled');
    	$totalClass = $request->input('class');
    	$courseLink = $request->input('link');
    	$img = $request->input('img');

    	$updateQuery = CourseModel::where('id','=',$updateId)->update([
    		'course_name'=>$name,
    		'course_des'=>$des,
    		'course_fee'=>$fee,
    		'course_totalenroll'=>$totalEnrolled,
    		'course_totalclass'=>$totalClass,
    		'course_link'=>$courseLink,
    		'course_img'=>$img
    	]);
    	if($updateQuery == true)
    	{
    		return 1;
		}
    	else
    	{
    		return 0;
    	}
    }
	//course section; add new course function
    function CoursesInsert(Request $request){
        $name = $request->input('name');
    	$des = $request->input('des');
    	$fee = $request->input('fee');
    	$totalEnrolled = $request->input('enrolled');
    	$totalClass = $request->input('class');
    	$courseLink = $request->input('link');
    	$img = $request->input('img');

        $insertQuery = ServicesModel::insert([
        	'course_name'=>$name,
        	'course_des'=>$des,
        	'course_fee'=>$fee,
        	'course_totalenroll'=>$totalEnrolled,
        	'course_totalclass'=>$totalClass,
        	'course_link'=>$courseLink,
        	'course_img'=>$img
        ]);
        if($insertQuery == true)
        {
            return 1;
        }
        else
        {
            return 0;
        }
    }
}
