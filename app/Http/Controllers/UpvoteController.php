<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Upvote;
use App\Downvote;
use App\Post;

class UpvoteController extends Controller
{

      public function add(Request $request)
      {
          $postId = $request->input('postId');
          $authorId = Auth::user()->id;
          $post = Post::findOrFail($postId);

          $upvote = Upvote::where('authorId', $authorId)->where('postId', $postId)->first();
          $potentialDownvote = Downvote::where('authorId', $authorId)->where('postId', $postId)->first();

          if($potentialDownvote)
          {
              $post->downvotes -= 1;
              $post->save();
              $potentialDownvote->delete();
          }

          if($upvote)
          {
              $post = Post::findOrFail($postId);
              $post->upvotes -= 1;
              $post->save();
              $upvote->delete();
          }

          else
          {
              $dwVote = Downvote::where('authorId', $authorId)->where('postId', $postId)->get();

              if($dwVote->count() > 0)
              {
                  $dwVote->delete();
                  $dwVote->save();
                  $post->downvotes -= 1;
              }

              $upvote = new Upvote();
              $upvote->authorId = $authorId;
              $upvote->authorName = Auth::user()->name;
              $upvote->postId = $postId;

              $post = Post::findOrFail($postId);
              $post->upvotes += 1;
              $upvote->save();
              $post->save();

          }
      }

      public function delete($postId)
      {

      }
}
