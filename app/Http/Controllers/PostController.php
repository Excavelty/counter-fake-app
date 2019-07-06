<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;

class PostController extends Controller
{
      public function index()
      {
          $perPage = 20;
          $howMany = 100;

          $posts = Post::getLatest($howMany, $perPage);
      }

      public function store(Request $request)
      {
          $rules = [
                'title' => 'max:120',
            ];

          $messages = [
              'max' => 'Tytuł powinien zawierać co najwyżej 120 znaków',
          ];

          $this->validate($request, $rules, $messages);

          $result = Post::storePost($request);
          if($result)
              return ['success' => 'Poprawnie dodano nowe ostrzeżenie'];
          else
              return ['error' => 'Wystąpił błąd'];
      }
}
