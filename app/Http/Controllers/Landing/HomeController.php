<?php

namespace App\Http\Controllers\Landing;

use App\Http\Controllers\Controller;
class HomeController extends Controller
{
    public function index()
    {
       dd('dsd');
    }

    public function termCondition()
    {
        $termCondition = getSetting('terms_of_service');
        return view('landing.term-condition', compact(['termCondition']));
    }

    public function privacyPolicy()
    {
        $privacyPolicy = getSetting('privacy_policy');
        return view('landing.privacy-policy', compact(['privacyPolicy']));
    }
}
