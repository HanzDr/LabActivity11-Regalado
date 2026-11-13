<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Models\Post;

class CommentController extends Controller
{
    public function store(StoreCommentRequest $request, Post $post)
    {
        $data = $request->validated();
        $data['user_id'] = $request->user()->id;

        $post->comments()->create($data);

        return redirect()
            ->route('posts.show', $post)
            ->with('status', 'Comment posted.');
    }
}
