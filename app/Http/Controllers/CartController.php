<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Categories;
use App\Products;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
//set limit to product
//decrease number when buy
//calculate the sum + add the sum to cart
class CartController extends Controller
{
    public function index()
    {
        /**
         * @var $cart Cart
         */
        $cart = Session::get('cart');
        $products = array();
        $quantities = array();
        foreach ($cart->getCart() as $key =>$item) {
            $products[] = Products::where('id',$key)->first();
            $quantities[] = $item;
        }
        $categories = Categories::all();
//        for($i=0 ;$i<2 ; $i++)
//        {
//            var_dump($categories[$i]);
//
//        }
//        die();
        return view('cart.index')
            ->withQuantities($quantities)
            ->withProducts($products)
            ->withCategories($categories);
    }

    /**
     * @param Request $request
     * @param $id
     * @return $this
     */
    public function add(Request $request,$id)
    {
        $product = Products::where('id',$id)->where('active',1)->first();
        if($product == NULL)
            return redirect('/')->withErrors('The product doesn\'t exist ' );
        /**
         * @var $cart Cart
         */
        $cart = Session::get('cart');
        if($product->quantity > 0)
        {
            $cart->addNewProduct($product->id);
            Session::put('cart',$cart);
        }
        else
            return redirect('/cart/index')->withErrors('The stock is insufficient');
        return redirect('/cart/index')->withMessage('Product successfully added to cart');


    }

    public function increase($id)
    {
        /**
         * @var $cart Cart
         */
        $cart = Session::get('cart');
        if($cart->checkProduct($id))
            $cart->increaseQuantity($id);
        else
            return redirect('/cart/index')->withErrors('Product not found');

        return redirect('/cart/index')->withMessage('Quantity increased successfully');
    }

  

}
