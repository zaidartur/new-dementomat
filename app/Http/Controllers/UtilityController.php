<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UtilityController extends Controller
{
    public function view_youtube()
    {
        $data = [];
        return view('utility.youtube', $data);
    }

    public function view_slider()
    {
        $data = [];
        return view('utility.slider', $data);
    }

    public function view_berita()
    {
        $data = [];
        return view('utility.berita', $data);
    }
}
