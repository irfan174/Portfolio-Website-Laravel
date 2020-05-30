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


    function ServiceDelete(Request $request){
    	$deleteId = $request->input('id');
    	$deleteQuery = ServicesModel::where('id','=',$deleteId)->delete();
    	if($deleteQuery == true)
    	{
    		return 1;

    	}
    	else{
    		return 0;

    	}


    }

    
}
