<?php

namespace App\Http\Controllers\Main_Controller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MainIndexController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


}
