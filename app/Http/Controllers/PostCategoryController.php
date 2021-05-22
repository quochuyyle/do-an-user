<?php

namespace App\Http\Controllers;

use App\Categories;
use App\PostCategory;
use Illuminate\Http\Request;

class PostCategoryController extends Controller
{
    public  function index(){
        $postCategories = PostCategory::all();
        $categories = Categories::all();
        return view('postcategory.index', compact('postCategories','categories'));
    }
}
