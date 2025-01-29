<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        if(!Auth::check()) {
            return view('auth.login');
        }
        $user = Auth::user();
        if($user->role === 'admin'){
            return view('admin.dashboard');
        }
        elseif($user->role === 'user'){
            if($user->approved) {
                return view('user.dashboard', [
                    'id' => $user->SekretariatID
                ]);
            }
            return view('approval');
        } 
        //return redirect()->intended(route('/', absolute: false));
    }
}
