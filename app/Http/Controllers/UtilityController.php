<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\Slider;
use App\Models\Youtube;
use Illuminate\Http\Request;

class UtilityController extends Controller
{
    public function view_youtube()
    {
        $data = [
            'list'  => Youtube::where('status', 'active')->get(),
        ];
        
        return view('utility.youtube', $data);
    }

    public function view_slider()
    {
        $data = [
            'list'  => Slider::where('status', 'active')->get(),
        ];

        return view('utility.slider', $data);
    }

    public function view_berita()
    {
        $data = [
            'list'  => Berita::where('status', 'active')->get(),
        ];

        return view('utility.berita', $data);
    }
}
