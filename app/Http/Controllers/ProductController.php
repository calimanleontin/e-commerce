<?php

namespace App\Http\Controllers;

use App\Categories;
use App\Comments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use App\Products;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class ProductController extends Controller
{
    public function index()
    {
        $products = Products::where('active',1)->paginate(9);
        $categories = Categories::all();
        return view('home')
            ->withProducts($products)
            ->withCategories($categories);
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
        $product->quantity = $request->input('quantity');
        $product->author_id = $user_id;
        $product->slug = str_slug($request->input('name'));
        $product->active = 1;

        if(Input::file('image') != null) {
            $destinationPath = 'images/catalog'; // upload path
            $extension = Input::file('image')->getClientOriginalExtension(); // getting image extension
            $fileName = rand(11111, 99999) . '.' . $extension; // renameing image
            $product->image = $fileName;
            Input::file('image')->move($destinationPath, $fileName); // uploading file to given path
        }
        $product->save();

        if($categories)
            foreach($categories as $category)
            {
                $category = Categories::where('title',$category)->first();
                $product->categories()->attach($category->id);
            }
        return redirect('/')->withMessage('New product created');
    }

    public function show($slug)
    {
        $product = Products::where('slug',$slug)->first();
        if($product == NULL)
            return redirect('/')->withErrors('Requested url does not exist');
      $comments = Comments::where('on_product',$product->id)->orderBy('created_at','asc')->paginate(5);
        $categories = Categories::all();
        return view('product.show')
            ->withProduct($product)
            ->withCategories($categories)
            ->withComments($comments);
    }

    public function edit(Request $request, $id)
    {
        $user = $request->user();
        $product = Products::find($id);
        if($user->id != $product->author_id and $user->is_admin() == false and $user->is_moderator() == false)
            return redirect('/')->withErrors('You have not sufficient permissions ');
        $categories = Categories::all();
        return view('product.edit')->withProduct($product)->withCategories($categories);
    }

    public function update(Request $request)
    {
        $user = $request->user();
        $id = $request->input('id');
        $product = Products::where('id',$id)->first();
        if($user->id != $product->author_id and $user->is_admin() == false and $user->is_moderator() == false)
            return redirect('/')->witheErrors('You have not sufficient permissions ');
        $name = $request->input('name');
        $quantity = $request->input('quantity');
        $description = $request->input('description');
        $image = Input::file('image');
        $categories = $request->input('category');
        $duplicate = Products::where('name',$name)->first();
        if($duplicate != null and $duplicate->id != $product->id)
            return redirect('/edit/product'.$product->id)->withErrors('The name is already in use');
        if($quantity != null)
            $product->quantity = $quantity;
        if($description != null)
            $product->description = $description;
        if($image != null)
        {
            $destinationPath = 'images/catalog'; // upload path
            $extension = Input::file('image')->getClientOriginalExtension();
            $fileName = rand(11111, 99999) . '.' . $extension;
            $product->image = $fileName;
            Input::file('image')->move($destinationPath, $fileName);
        }
        if ($categories != null)
        {
            $product->categories()->detach();
            foreach($categories as $category)
            {
                $category = Categories::where('title',$category)->first();
                $product->categories()->attach($category->id);
            }
        }
        $product->save();
        return redirect('/product/'.$product->slug)->withMessage('Product updated successfully');

    }

    public function search(Request $request)
    {
        $term = $request->get('q');
        $categories = Categories::all();
        $products = Products::where('name','like','%'.$term.'%')->paginate(9);
        return view('home')->withProducts($products)
            ->withCategories($categories)
            ->withTerm($term);

    }
    public function sort(Request $request)
    {
        $criterion = $request->get('criterion');
        $order = $request->get('order');
        $categories = Categories::all();
        $products = Products::where('active',1)->orderBy($criterion,$order)->paginate(9);
        return view('home')->withProducts($products)
            ->withTitle('Sort results')
            ->withCategories($categories)
            ->withOrder($order)
            ->withCriterion($criterion);
    }

}
