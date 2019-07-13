<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Media;
use Illuminate\Support\Facades\Input;

class MediaController extends Controller
{
    public function index()
    {
        $howMany = Input::get('howMany');
        if($howMany === 'all')
            $media = Media::orderBy('result', 'desc')->get();
        else
            $media = Media::orderBy('result', 'desc')->take($howMany)->get();

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
