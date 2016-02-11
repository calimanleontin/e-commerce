<?php

namespace App\Http\Controllers;

use App\Categories;
use App\Products;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public function create(Request $request)
    {
        $categories = Categories::all();
        if($request->user()->can_create_category())
            return view('category.create')
                ->withCategories($categories);
        return redirect('/')
            ->withErrors('You have not sufficient permission to create a new category');
    }

    public function store(Request $request)
    {
        $category = new Categories();
        $category->title = $request->input('title');
        $category->description = $request->input('description');
        $category->slug = str_slug($category->title);
        $category->author_id = $request->user()->id;
        $category->save();
        return redirect('/')->withMessage('New category created');
    }

    public function show($slug)
    {
        /**
         * @var $category Categories
         */
        $category = Categories::where('slug',$slug)->first();
        if($category == NULL)
            return redirect('/')->withErrors('Requested url does not exist');
        $categories = Categories::all();
        /**
         * @var $products Products
         */
        $products = $category->products()->paginate(9);
        return view('home')->withProducts($products)
            ->withCategories($categories)
            ->withTitle('Products from the  category '.$category->title);
    }

}
