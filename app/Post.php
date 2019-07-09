<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Post extends Model
{
    protected $fillable = ['title', 'content', 'type'];

    public static function getLatest($howMany, $perPage)
    {
        $posts = Post::orderBy('created_at', 'desc')->take($howMany)->paginate($perPage)
          ->onEachSide(1);
        return $posts;
    }

    public static function storePost(Request $request)
    {
        $post = new Post($request->all());
        $post->upvotes = 0;
        $post->downvotes = 0;
        $post->authorId = Auth::user()->id;
        return $post->save();
    }

    private function validatePost(Request $request)
    {

    }
}
