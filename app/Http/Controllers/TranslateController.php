<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Stichoza\GoogleTranslate\GoogleTranslate;

class TranslateController extends Controller
{
    public function index()
    {
        $tr = new GoogleTranslate('en'); // Translates into English
        $text = $tr->translate('<b>Aku mau makan</b>');
        return $text;
    }
}
