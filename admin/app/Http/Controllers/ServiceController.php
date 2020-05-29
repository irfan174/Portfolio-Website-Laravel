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
}
