<?php

namespace App\Http\Controllers;

use App\Categories;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use App\Products;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class ProductController extends Controller
{
    public function index()
    {
        $products = Products::where('active',1)->get();
        $categories = Categories::all();
        return view('home')->withProducts($products)->withCategories($categories);
    }
}
