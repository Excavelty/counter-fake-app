<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function index($id)
    {
        $comments = Comment::where('postId', $id)->orderBy('created_at', 'desc')->get();
        if($comments->count())
            return ['comments' => $comments];
        else
            return ['error' => 'Nie znaleziono żadnych komentarzy'];
    }

    public function store($postId, Request $request)
    {
        $this->validateComment($request);
        $comment = new Comment($request->all());
        $comment->postId = $postId;
        $comment->authorName = Auth::user()->name;
        $comment->upvotes = $comment->downvotes = 0;
        $result = $comment->save();

        if($result)
            return ['success' => 'Poprawnie dodano komentarz'];
        else
            return ['error' => 'Wystąpił nieoczekiwany błąd'];
    }

    private function validateComment(Request $request)
    {
        $rules = [
            'content' => 'min:14|max:300',
        ];

        $messages = [
            'content.min' => 'Treść komentarza powinna składać się z co najmniej :min znaków',
            'content.max' => 'Treść komentarza powinna składać się z co najmniej :max znaków'
        ];

        $this->validate($request, $rules, $messages);
    }
}
