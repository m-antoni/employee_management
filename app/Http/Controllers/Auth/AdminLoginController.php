<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Admin;
use Validator;

class AdminLoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth-admin.login');
    }

    public function login(Request $request)
    {

        // Validation form data
        $data = request()->validate([
            'username' => 'required',
            'password' => 'required|min:3'
        ]);

        // Attempt to log in using qrcode
        if(Auth::guard('admin')->attempt(['username' => $request->username, 'password' => $request->password])){

            return redirect()->intended(route('admin.dashboard'));

            // this is for vue-components only
            //return ['redirect' => route('admin.dashboard')];
            // $redirect = response(['redirect' => route('admin.dashboard')], 200)                        
            //                     ->header('Content-Type', 'text/plan');
            // return $redirect;
        }
        
        return redirect()->back()->with($request->only('username'));

        // this is for vue-components only
        // $response = response(['message' => 'Unauthorized Attempt To Log In!',], 422)
        //                     ->header('Content-Type', 'text/plan');
        // return $response;
    }


    public function adminLogout()
    {
        Auth::guard('admin')->logout();

        return redirect('/admin/login');
    }
}
