<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;

class CommentController extends Controller
{
    public function index($id)
    {
        $comments = Comment::where('postId', $id)->get();
        if($comments->count())
            return ['comments' => $comments];
        else
            return ['error' => 'Nie znaleziono żadnych komentarzy'];
    }
}
