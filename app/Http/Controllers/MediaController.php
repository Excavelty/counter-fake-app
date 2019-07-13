<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Media;
use Illuminate\Support\Facades\Input;

class MediaController extends Controller
{
    public function index()
    {
        $howMuch = Input::get('howMuch');
        $media = Media::orderBy('result')->take($howMuch)->get();

        if($media->count())
            return ['media' => $media];
        else
            return ['error' => 'Brak wyników lub wystąpił nieoczekiwany błąd'];
    }

    public function show()
    {
        $media = Media::orderBy('result')->take(10)->get();
        return view('rank')->with('media', $media);
    }
}
