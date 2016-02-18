<?php
namespace App\Http\Controllers;

use App\Cart;
use App\Categories;
use App\Comments;
use App\Profiles;
use App\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Input;
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
        $duplicate_name = User::where('name',$name)->first();
        $duplicate_email = User::where('email',$email)->first();
        if($duplicate_name != null)
            return redirect('/auth/register')->withErrors('Name already used');
        if($duplicate_email != null)
            return redirect('/auth/register')->withErrors('Email already used');
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
        $profile = new Profiles;
        $user->profile()->save($profile);
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
        $cart = new Cart();
        $dictionary = $user->dictionary;
//        var_dump($dictionary);
//        die();
        if(strlen($dictionary != 0)) {
            for ($i = 0; $i <strlen($dictionary)-1; $i+=2) {
//                var_dump($i);
                $key = $dictionary[$i];
                $i += 2;
                $value = $dictionary[$i];
                $cart->addNewProduct($key);
                $cart->setQuantity($key,$value);
            }
        }
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
    public function getLogout(Request $request)
    {
        /**
         * @var $cart Cart
         */
        $cart = Session::get('cart');
        $dictionary = null;
        foreach($cart->getCart() as $key=>$value) {
            $dictionary = $dictionary.$key.' '.$value.' ';
        }
        $user = $request->user();
        $user->dictionary = $dictionary;
        $user->save();

        Auth::logout();
        Session::forget('cart');
        return redirect('/')->withMessages('You logged out successfully');
    }

    public function profile(Request $request)
    {
        /**
         * @var $user User
         */
        $user = $request->user();
        $comments = $user->comments()->get();


        return view('auth.profile')->withUser($user)
            ->withComments($comments);
    }
    public function edit_profile(Request $request)
    {
        return view('auth.edit_profile');
    }

    public function update_profile(Request $request)
    {
        /**
         * @var $user User
         */
        $user = $request->user();
        $profile = $user->profile()->first();
        $profile->firstName = $request->input('firstName');
        $profile->lastName = $request->input('lastName');
        $profile->birthday = $request->input('birthday');
        $profile->telephoneNumber = $request->input('telephone');
//        $profile->about = $request->input('about');


        $destinationPath = 'images/users';
        $extension = Input::file('image')->getClientOriginalName();
        $fileName = rand(11111,99999).'.'.$extension;
        $profile->picture = $fileName;
        Input::file('image')->move($destinationPath, $fileName); // uploading file to given path
        $profile->save();
        $user->profile()->save($profile);
        return redirect ('/user-profile')->withMessage('Updates made successfully');
    }

}
