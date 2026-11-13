<?php

namespace App\Http\Controllers;

use App\Models\Author;

class AuthorController extends Controller
{
    public function show($author)
    {
        $author = Author::findOrFail($author);
        $author->load([
            'posts' => fn ($query) => $query
                ->where('is_published', true)
                ->with(['author', 'tags'])
                ->withCount('comments')
                ->orderByDesc('is_pinned')
                ->latest('published_at'),
        ]);

        $commentsCount = $author->comments()
            ->whereHas('post', fn ($query) => $query->where('is_published', true))
            ->count();

        return view('authors.show', compact('author', 'commentsCount'));
    }
}
