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
    public function create(Request $request)
    {
        $categories = Categories::all();
        if($request->user()->can_create_category())
            return view('product.create')->withCategories($categories);
        return redirect('/')->withErrors('You have not sufficient permissions to add a new product');
    }

    public function store(Request $request)
    {
        $categories = $request->input('category');
        $name = $request->input('name');
        $duplicate = Products::where('name',$name)->first();
        if($duplicate)
            return redirect('/product/create')->withErrors('The name already exists');
        $description = $request->input('description');
        $price = $request->input('price');
        $user_id = $request->user()->id;
        $product = new Products();
        $product->name = $name;
        $product->description = $description;
        $product->price = $price;
        $product->author_id = $user_id;
        $product->slug = str_slug($request->input('name'));
        $product->active = 1;
        $product->save();
        if($categories)
            foreach($categories as $category)
            {
                $category = Categories::where('title',$category)->first();
                $product->categories()->attach($category->id);
            }
        return redirect('/')->withMessage('New product created');


    }
}
