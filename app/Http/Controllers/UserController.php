<?php

namespace App\Http\Controllers;


use App\User;
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
        return view('auth.register');
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
        return  redirect('/')->withMessage('Registered successfully');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getLogin()
    {
        return view('auth.login');
    }

    public function postLogin(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');

        $user = User::where('email',$email)->first();
//        var_dump(bcrypt($password));
//        die();
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
        Auth::logout();
        return redirect('/')->withMessages('You logged out successfully');
    }

}
