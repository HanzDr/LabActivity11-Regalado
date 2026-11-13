<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function create()
    {
        abort_unless(auth()->user()->author()->exists(), 403);

        return view('posts.create', [
            'categories' => [
                'Announcement',
                'Health',
                'Peace & Order',
                'Ayuda',
                'Community Events',
            ],
            'tags' => Tag::query()->orderBy('name')->get(),
        ]);
    }

    public function store(StorePostRequest $request)
    {
        $data = $request->validated();
        $tagIds = $data['tags'];
        unset($data['tags']);

        $data['is_published'] = (bool) ($data['is_published'] ?? false);
        $data['published_at'] = $data['is_published'] ? now() : null;

        $author = $request->user()->author()->firstOrFail();
        $post = $author->posts()->create($data);
        $post->tags()->sync($tagIds);

        return redirect()
            ->route('posts.show', $post)
            ->with('status', 'Post created.');
    }

    public function index(Request $request)
    {
        $query = Post::query()
            ->with(['author', 'tags'])
            ->withCount('comments')
            ->where('is_published', true);

        if ($request->filled('q')) {
            $query->where('title', 'like', '%'.$request->input('q').'%');
        }

        if ($request->filled('category')) {
            $query->where('category', $request->input('category'));
        }

        if ($request->filled('tag')) {
            $query->whereHas('tags', function ($tagQuery) use ($request) {
                $tagQuery->where('name', $request->input('tag'));
            });
        }

        $posts = $query
            ->orderByDesc('is_pinned')
            ->latest('published_at')
            ->paginate(8)
            ->withQueryString();

        $categories = Post::query()
            ->distinct()
            ->orderBy('category')
            ->pluck('category');

        $tags = Tag::query()
            ->orderBy('name')
            ->pluck('name');

        return view('posts.index', compact('posts', 'categories', 'tags'));
    }

    public function show($id)
    {
        $post = Post::findOrFail($id);

        abort_if(! $post->is_published, 404);

        $post->views += 1;
        $post->save();

        $post->load([
            'author',
            'tags',
            'comments.user',
        ]);
        $post->setRelation(
            'comments',
            $post->comments->sortByDesc('created_at')->values()
        );

        return view('posts.show', compact('post'));
    }
}
