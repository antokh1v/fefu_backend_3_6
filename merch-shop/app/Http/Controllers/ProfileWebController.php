<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileWebController extends Controller
{
    public function show()
    {
        return view('profile');
    }
}
