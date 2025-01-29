<?php

namespace App\Http\Controllers\UserPanel;

use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function index($id)
    {
        return view('user.dashboard', [
            'id' => $id
        ]);
    }
}
