<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Products;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function add(Request $request,$id)
    {
        $product = Products::find($id);
        /**
         * @var $cart Cart
         */
        $cart = Session::get('cart');
        $cart->addNewProduct($product->id);
        var_dump($cart->getCart());

    }
}
