<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Upvote;
use App\Downvote;

class Upvote extends Model
{
    public function add($postId)
    {
        $authorId = Auth::user()->id;
        if(Upvote::where('authorId', $authorId)->andWhere('postId', $postId)->get()->count() > 0)
          return ['error' => 'Nie można głosować dwa razy'];
        else
        {
            $dwVote = Downvote::where('authorId', $authorId)->andWhere('postId', $postId)->get()

            if($dwVote->count() > 0)
            {
                $dwVote->delete();
                $dwVote->save();
            }

            $upvote = new Upvote();
            $upvote->authorId = $authorId;
            $upvote->authorName = Auth::user()->name;
            $upvote->postId = $postId;

            $result = $upvote->save();
            if($result)
                return ['success' => true];
            else
                return ['success' => false];
        }
    }

    public function delete($postId)
    {

    }
}
