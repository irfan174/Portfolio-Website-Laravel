<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ServicesModel;

class ServiceController extends Controller
{
    //service section; service view
     function ServiceIndex(){
     	
		return view('Services');
    }
    //service section; get all data from database and send to custom.js in getServiceJsonData function
	function getServiceData(){
		$allServiceData = json_encode(ServicesModel::all());
		return $allServiceData;
    }
	//service section; service delete function
	function ServiceDelete(Request $request){
    	$deleteId = $request->input('id');
    	$deleteQuery = ServicesModel::where('id','=',$deleteId)->delete();
    	if($deleteQuery == true)
    	{
    		return 1;
		}
    	else
    	{
    		return 0;
    	}
    }
    //service section; get all details [all coloumns] of each data for edit service
    function getServiceDetailsData(Request $request){
    	$editId = $request->input('id');
    	$editQuery = json_encode(ServicesModel::where('id','=',$editId)->get()) ;
    	return $editQuery;

    }
    //service section; service update function
    function ServiceUpdate(Request $request){ 
    	$updateId = $request->input('id');
    	$name = $request->input('name');
    	$des = $request->input('des');
    	$img = $request->input('img');

    	$updateQuery = ServicesModel::where('id','=',$updateId)->update(['service_name'=>$name,'service_des'=>$des,'service_img'=>$img]);
    	if($updateQuery == true)
    	{
    		return 1;
		}
    	else
    	{
    		return 0;
    	}
    }
    //service section; add new service function
    function ServiceInsert(Request $request){
        $name = $request->input('name');
        $des = $request->input('des');
        $img = $request->input('img');

        $insertQuery = ServicesModel::insert(['service_name'=>$name,'service_des'=>$des,'service_img'=>$img]);
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
