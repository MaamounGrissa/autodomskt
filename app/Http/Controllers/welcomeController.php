<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\category;

class welcomeController extends Controller
{
    public function index()
    {
        $categories = category::orderBy('order', 'asc')->get();
        $mainCategories = category::with("image")->where('parent', 0)->orderBy('order', 'asc')->get();
        return view('welcome', compact('categories', 'mainCategories'));
    }
}
