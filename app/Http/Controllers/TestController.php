<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Translator;

class TestController extends Controller
{
    /* 
     * Translate part of logo code for speed test
     */
    
    public function translate(Request $request){
        $translator = new Translator();
        $json = $translator->translate($request->logo);
        print $json;
    }
    
}
