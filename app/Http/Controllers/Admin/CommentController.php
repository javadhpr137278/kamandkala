<?php

namespace App\Http\Controllers\Admin;

use App\Enums\CommentStatus;
use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function userComments()
    {
        $comments = Comment::query()->orderBy('created_at','DESC')->paginate(20);
        return view('admin.comments.list',compact('comments'));
    }

    public function changeStatus(Comment $comment)
    {
        $comment->status = $comment->status === CommentStatus::Approved->value
            ? CommentStatus::Draft->value
            : CommentStatus::Approved->value;

        $comment->save();

        return back()->with('message', 'وضعیت نظر با موفقیت تغییر یافت.');
    }


}
