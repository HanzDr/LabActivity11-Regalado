@extends('layouts.app')

@section('content')
    <div class="mx-auto max-w-3xl">
        <a href="{{ route('posts.index') }}" class="mb-6 inline-block font-medium text-emerald-800 underline underline-offset-4 hover:text-emerald-950">
            ← Back to all posts
        </a>

        @if (session('status'))
            <div class="mb-6 rounded-lg border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-800" role="status">
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-6 rounded-lg border border-red-200 bg-red-50 p-4 text-sm text-red-800" role="alert">
                <p class="font-semibold">Please fix the following errors:</p>
                <ul class="mt-2 list-disc space-y-1 pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <article class="rounded-xl border border-stone-200 bg-white p-6 shadow-sm sm:p-10">
            <div class="mb-5 flex flex-wrap items-center gap-2">
                <span class="rounded-full bg-emerald-50 px-3 py-1 text-sm font-semibold text-emerald-800">
                    {{ $post->category }}
                </span>
                @if ($post->is_pinned)
                    <span class="rounded-full bg-amber-100 px-3 py-1 text-sm font-semibold text-amber-900">Pinned</span>
                @endif
            </div>

            <h1 class="text-3xl font-bold leading-tight tracking-tight break-words sm:text-4xl">{{ $post->title }}</h1>

            <div class="mt-5 flex flex-wrap gap-x-5 gap-y-2 border-b border-stone-200 pb-6 text-sm text-slate-500">
                <span>Published {{ $post->published_at?->format('F j, Y') ?? 'Date unavailable' }}</span>
                <span>
                    By
                    <a href="{{ route('authors.show', $post->author) }}" class="font-medium text-emerald-800 hover:underline">
                        {{ $post->author->name }}
                    </a>
                </span>
                <span>{{ $post->views }} {{ $post->views === 1 ? 'view' : 'views' }}</span>
            </div>

            @if ($post->tags->isNotEmpty())
                <div class="mt-5 flex flex-wrap gap-2">
                    @foreach ($post->tags as $tag)
                        <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-700">
                            {{ $tag->name }}
                        </span>
                    @endforeach
                </div>
            @endif

            <div class="mt-6 leading-8 whitespace-pre-wrap break-words text-slate-700">{{ $post->body }}</div>
        </article>

        <section class="mt-8">
            <h2 class="text-2xl font-bold">Comments ({{ $post->comments->count() }})</h2>

            @forelse ($post->comments as $comment)
                <article class="mt-4 rounded-xl border border-stone-200 bg-white p-5 shadow-sm">
                    <div class="flex flex-wrap items-baseline justify-between gap-2">
                        <p class="font-semibold">{{ $comment->user->name }}</p>
                        <time datetime="{{ $comment->created_at->toISOString() }}" class="text-sm text-slate-500">
                            {{ $comment->created_at->format('M j, Y g:i A') }}
                        </time>
                    </div>
                    <p class="mt-3 whitespace-pre-wrap break-words text-slate-700">{{ $comment->body }}</p>
                </article>
            @empty
                <p class="mt-4 rounded-xl border border-dashed border-stone-300 bg-white p-6 text-slate-600">
                    No comments yet.
                </p>
            @endforelse

            @auth
                <form method="POST" action="{{ route('comments.store', $post) }}" class="mt-6 rounded-xl border border-stone-200 bg-white p-5 shadow-sm">
                    @csrf
                    <label for="body" class="mb-2 block text-sm font-medium">Add a comment</label>
                    <textarea id="body" name="body" rows="4" required class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:border-emerald-700 focus:outline-2 focus:outline-emerald-700">{{ old('body') }}</textarea>
                    @error('body')
                        <p class="mt-1 text-sm text-red-700">{{ $message }}</p>
                    @enderror
                    <button type="submit" class="mt-3 rounded-lg bg-emerald-800 px-5 py-2.5 font-semibold text-white hover:bg-emerald-900 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-emerald-800">
                        Post comment
                    </button>
                </form>
            @else
                <p class="mt-6 rounded-xl border border-stone-200 bg-white p-5 text-slate-600">
                    <a href="{{ route('login') }}" class="font-medium text-emerald-800 underline underline-offset-4">Sign in to comment</a>
                </p>
            @endauth
        </section>
    </div>
@endsection
