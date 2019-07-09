<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class PostController extends Controller
{
      public function index()
      {
          $howMany = 100;
          $perPage = 6;

          $posts = Post::getLatest($howMany, $perPage);

          if($posts->count() > 0)
              return view('home')->with('posts', $posts);
          else
              return view('home')->with('errors', 'Nie znaleziono żadnych ostrzeżeń lub wystąpił nieoczekiwany błąd');
      }

      public function search()
      {
          $title = Input::get('title');
          $singleWords = explode(' ', $title);
          $query = Post::query();

          foreach($singleWords as $word)
          {
              $query->orWhere('title', 'like', '%'. $word .'%');
          }

          $posts = $query->take(5)->get();
          return ['posts' => $posts];
      }

      public function store(Request $request)
      {
          $rules = [
                'title' => 'min:14|max:120',
                'description' => 'min:14|max:1750',
                'type' => 'required',
          ];

          $messages = [
              'title.min' => 'Tytuł powinien składać się z co najmniej :min znaków',
              'description.min' => 'Opis powinien składać się z co najmniej :min znaków',
              'title.max' => 'Tytuł powinien składać się z co najwyżej :max znaków',
              'description.max' => 'Opis powinien składać się z co najwyżej :max znaków',
              'type.required' => 'Należy wybrać typ',
          ];

          $this->validate($request, $rules, $messages);

          $result = Post::storePost($request);
          if($result)
              return ['success' => 'Poprawnie dodano nowe ostrzeżenie'];
          else
              return ['error' => 'Wystąpił błąd'];
      }
}
