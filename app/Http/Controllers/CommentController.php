<?php

namespace App\Http\Controllers;

use App\Providers\AuthServiceProvider;
use Illuminate\Http\Request;
use App\Comment;
use Illuminate\Support\Facades\Auth;
use Pusher;

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

    public function getComments(\App\Http\Requests\GetCommentsRequest $request)
    {
        $comments = Comment::query()->where('item_id', $request->id)->get();
        return $comments->toJson();
    }

    public function storeComment(\App\Http\Requests\StoreCommentRequest $request)
    {
        Comment::query()->insert([
            'item_id' => $request->item_id,
            'description' => $request->comment,
            'userid' => Auth::id(),
            'date' => date('Y-m-d H:i:s')
        ]);
        $pusher = new Pusher\Pusher(
            'b97ad9c93b6c1252a940',
            'f5f2ab83277361ff2ffd',
            '431398');
//            event(new \App\Events\CommentPosted($request->item_id));
        $pusher->trigger('comment' . $request->item_id, 'comment-posted', Auth::id());
        $comments = Comment::query()->where('item_id', $request->item_id)->get();
        return $comments->toJson();

    }
}
