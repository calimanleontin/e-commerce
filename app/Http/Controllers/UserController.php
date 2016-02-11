<?php

namespace App\Http\Controllers;


use App\Cart;
use App\Categories;
use App\User;
use Illuminate\Support\Facades\Session;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use \Auth;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller

{

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getRegister()
    {
        $categories = Categories::all();
        return view('auth.register')
            ->withCategories($categories);
    }

    /**
     * @param Request $request
     * @return Redirect
     */
    public function postRegister(Request $request)
    {
        $name = $request->input('name');
        $email = $request->input('email');
        $password = $request->input('password');
        if($name == '' || $email == '' || $password == '')
            return view('auth.register')->withName($name)->withEmail($email)->withErrors('Please fill all the fields');
        $password_confirmation = $request->input('password_confirmation');
        if($password != $password_confirmation)
            return view('auth.register')->withName($name)->withEmail($email)->withErrors('The passwords must coincide');
        $user = new User();
//        var_dump($user);
//        die();
        $user->name = $name;
        $user->email = $email;
        $user->password = bcrypt($password);
        $user->save();
        Auth::login($user);
        $cart = new Cart();
        $cart->setOwnerId($user->id);
        Session::put('cart',$cart);
        return  redirect('/')->withMessage('Registered successfully');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getLogin()
    {
        $categories = Categories::all();
        return view('auth.login')
            ->withCategories($categories);
    }

    public function postLogin(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');

        $user = User::where('email',$email)->first();
        if($user == NULL)
            return view('auth.login')->withErrors('Email has not been found');
//        var_dump(bcrypt($password));
//        die();
        $cart = new Cart();
        $cart->setOwnerId($user->id);
        Session::put('cart',$cart);
        if (Hash::check($password, $user->password)) {
            Auth::login($user);
            return redirect('/')->withMessage('Logged in successfully');
        }
        else
            return view('auth.login')->withErrors('wrong password');
    }

    /**
     * @return mixed
     */
    public function getLogout()
    {
        /**
         * @var $cart Cart
         */
        $cart = Session::get('cart');
        $dictionary = null;
        foreach($cart->getCart() as $key=>$value) {
            $dictionary = $dictionary.$key.' '.$value.' ';

        }
        Auth::logout();
        Session::forget('cart');
        return redirect('/')->withMessages('You logged out successfully');
    }

}
