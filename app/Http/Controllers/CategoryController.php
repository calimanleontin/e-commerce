<?php

namespace App\Http\Controllers;

use App\Categories;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public function create(Request $request)
    {
        if($request->user()->can_create_category())
            return view('category.create');
        return redirect('/')->withErrors('You have not sufficient permission to create a new category');
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
}
