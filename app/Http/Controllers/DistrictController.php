<?php

namespace App\Http\Controllers;

use App\District;
use Illuminate\Http\Request;

class DistrictController extends Controller
{
    //

    public function getList(Request $request)
    {
        if($request->ajax()){
            $province_id=$request->province_id;
            $districts=District::where('province_id',$province_id)->get();
            return $districts;
        }
    }
}
