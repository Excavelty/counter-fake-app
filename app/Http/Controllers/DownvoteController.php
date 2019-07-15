<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Downvote;
use App\Upvote;
use App\Post;
use Illuminate\Support\Facades\Auth;

class DownvoteController extends Controller
{
    public function add(Request $request)
    {
        $postId = $request->input('postId');
        $authorId = Auth::user()->id;
        $post = Post::findOrFail($postId);

        $potentialDownvote = Downvote::where('postId', $postId)->where('authorId', $authorId)->first();
        $potentialUpvote = Upvote::where('postId', $postId)->where('authorId', $authorId)->first();

        if($potentialUpvote)
        {
            $post->upvotes -= 1;
            $post->save();
            $potentialUpvote->delete();//maybe move to Post model
        }

        if($potentialDownvote)
        {
              $post->downvotes -= 1;
              $post->save();
              $potentialDownvote->delete();
        }

        else
        {
              $post->downvotes += 1;
              $downvote = new Downvote();
              $downvote->postId = $postId;
              $downvote->authorId = $authorId;
              $downvote->authorName = Auth::user()->name;

              $post->save();
              $downvote->save();
        }

    }
}
