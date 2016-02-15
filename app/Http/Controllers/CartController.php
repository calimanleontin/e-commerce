<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Categories;
use App\Order_History;
use App\Orders;
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
    /**
     * @return mixed
     */
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
       if($request->user() == null)
           return redirect('/auth/login')->withErrors('You first have to login');
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

    /**
     * @param $id
     * @return $this
     */
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

    /**
     * @param $id
     * @return $this
     */
    public function decrease($id)
    {
        /**
         * @var $cart Cart
         */
        $cart = Session::get('cart');
        if($cart->checkProduct($id)) {
            if($cart->getQuantity($id) >1)
                $cart->decreaseQuantity($id);
            else
            {
                return redirect('/cart/index')->withErrors('Can\'t decrease a quantity to 0');
            }
        }
        else
            return redirect('/cart/index')->withErrors('Product not found');

        return redirect('/cart/index')->withMessage('Quantity increased successfully');
    }

    /**
     * @param $id
     * @return $this
     */
    public function delete($id)
    {
        /**
         * @var $cart Cart
         */
        $cart = Session::get('cart');
        if($cart->checkProduct($id))
            $cart->removeProduct($id);
        else
            return redirect('/cart/index')->withErrors('Product not found');

        return redirect('/cart/index')->withMessage('Product erased from cart successfully');
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function finish(Request $request)
    {
        /**
         * @var $cart Cart
         */
        $cart = Session::get('cart');
        $order_id = null;
        /**
         * @var $last_order Orders
         */
        $last_order = Orders::whereNotNull('id')->orderBy('updated_at','desc')->first();
        if($last_order == Null)
        {
            $order_id = 1;
        }
        else
        {
            $order_id = $last_order->order_id + 1;
        }
        foreach($cart->getCart() as $product_id => $quantity)
        {
            $order = new Orders();
            $order->order_id = $order_id;
            $order->product_id = $product_id;
            $order->quantity = $quantity;
            $order->author_id = $request->user()->id;
            $order->save();
        }

        return redirect('/')->withMessage('Order processed successfully');
    }

}
