<?php

namespace App\Http\Controllers;

use App\Providers\AuthServiceProvider;
use Illuminate\Http\Request;
use App\Comment;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    //

    public function showComments($id)
    {
        $comments = Comment::query()->where('item_id', $id)->get();
        return \View::make('comments', [
            'comments' => $comments,
            'item_id' => $id,
        ]);
    }

    public function storeComment(\App\Http\Requests\StoreCommentRequest $request)
    {
        if (Auth::check()) {
            Comment::query()->insert([
                'item_id' => $request->item_id,
                'description' => $request->comment,
                'userid' => Auth::id(),
                'date' => date('Y-m-d H:i:s')
            ]);

            return redirect()->route('comments', $request->item_id);
        } else {
            return redirect()->route('login');
        }

    }
}
