<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class PostController extends Controller
{
      public function show($id)
      {
          $post = Post::find($id);
          if($post)
              return view('show')->with('post', $post);
          else
              abort('404');
      }
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

          $posts = $query->take(8)->get();
          return ['posts' => $posts];
      }

      public function update($id)
      {
          $post = Post::find($id);
          if($post && $post->authorId == Auth::user()->id)
              return view('update')->with('post', $post);
          else if($post && $post->id != Auth::user()->id)
              return redirect('/home');
          else
              abort(404);
      }

      public function put($id, Request $request)
      {
          $this->validateRequest($request);
          $post = Post::find($id);//think of it wheter its enough or not
          $post->update($request->all());

          if($post && $post->save())
              return ['success' => 'Poprawnie edytowano ostrzeżenie'];
          else
              return ['error' => 'Wystąpił błąd'];

      }

      public function store(Request $request)
      {
          $this->validateRequest($request);

          $result = Post::storePost($request);
          if($result)
              return ['success' => 'Poprawnie dodano nowe ostrzeżenie'];
          else
              return ['error' => 'Wystąpił błąd'];
      }

      public function getVotes()
      {
          $id = Input::get('postId');
          $post = Post::find($id);
          return ['upvotes' => $post->upvotes, 'downvotes' => $post->downvotes];
      }

      private function validateRequest(Request $request)
      {
          $rules = [
                'title' => 'min:14|max:120',
                'content' => 'min:14|max:1750',
                'type' => 'required',
          ];

          $messages = [
              'title.min' => 'Tytuł powinien składać się z co najmniej :min znaków',
              'content.min' => 'Opis powinien składać się z co najmniej :min znaków',
              'title.max' => 'Tytuł powinien składać się z co najwyżej :max znaków',
              'content.max' => 'Opis powinien składać się z co najwyżej :max znaków',
              'type.required' => 'Należy wybrać typ',
          ];

          $this->validate($request, $rules, $messages);
      }
}
