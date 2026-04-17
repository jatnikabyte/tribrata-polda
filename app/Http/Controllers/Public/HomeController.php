<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Speech;
use App\Models\Tabloid;
use App\Models\Video;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $videos= Video::where('is_active',1)->latest()->limit(9)->get();
        $tabloids= Tabloid::where('is_active',1)->latest()->limit(24)->get();
        $speeches= Speech::where('is_active',1)->latest()->limit(10)->get();
        return view('public.home',compact(['videos','tabloids','speeches']));
    }
}
