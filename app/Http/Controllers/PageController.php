<?php

namespace App\Http\Controllers;

use App\Categories;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public  function paymentMethod(){
        $categories = Categories::all();
        return view('pages.payment', compact('categories'));
    }
}
