<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ServicesModel;

class ServiceController extends Controller
{
     function ServiceIndex(){
     	
		return view('Services');
    }

	function getServiceData(){
		$allServiceData = json_encode(ServicesModel::all());
		return $allServiceData;
    }
	//service delete function
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
    //get all details [all coloumns] of each data for edit service
    function getServiceDetailsData(Request $request){
    	$editId = $request->input('id');
    	$editQuery = json_encode(ServicesModel::where('id','=',$editId)->get()) ;
    	return $editQuery;

    }
    //service update function
    function ServiceUpdate(Request $request){
    	$updateId = $request->input('id');
    	$serName = $request->input('name');
    	$serDes = $request->input('des');
    	$serImg = $request->input('img');

    	$updateQuery = ServicesModel::where('id','=',$updateId)->update(['service_name'=>$serName,'	service_des'=>$serDes,'service_img'=>$serImg]);
    	if($updateQuery == true)
    	{
    		return 1;
		}
    	else
    	{
    		return 0;
    	}
    }
}
