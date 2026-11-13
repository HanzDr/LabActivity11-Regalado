@extends('layouts.app')

@section('content')
    <div class="mx-auto max-w-5xl">
        <a href="{{ route('posts.index') }}" class="mb-6 inline-block font-medium text-emerald-800 underline underline-offset-4 hover:text-emerald-950">
            ← Back to all posts
        </a>

        <header class="rounded-xl border border-stone-200 bg-white p-6 shadow-sm sm:p-8">
            <p class="mb-2 text-sm font-semibold uppercase tracking-wide text-emerald-700">Author profile</p>
            <h1 class="text-3xl font-bold tracking-tight sm:text-4xl">{{ $author->name }}</h1>
            <p class="mt-2 text-lg text-slate-600">{{ $author->position }}</p>
            <p class="mt-4 text-sm text-slate-600">
                {{ $commentsCount }} {{ $commentsCount === 1 ? 'comment' : 'comments' }} received
            </p>
        </header>

        <section class="mt-8">
            <h2 class="text-2xl font-bold">Published posts</h2>

            <div class="mt-4 grid gap-5 md:grid-cols-2">
                @forelse ($author->posts as $post)
                    <article class="flex flex-col rounded-xl border border-stone-200 bg-white p-6 shadow-sm">
                        <div class="mb-4 flex flex-wrap items-center gap-2">
                            <span class="rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-800">
                                {{ $post->category }}
                            </span>
                            @if ($post->is_pinned)
                                <span class="rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-900">Pinned</span>
                            @endif
                        </div>

                        <h3 class="text-xl font-bold leading-snug break-words">
                            <a href="{{ route('posts.show', $post->id) }}" class="hover:text-emerald-800 hover:underline">
                                {{ $post->title }}
                            </a>
                        </h3>
                        <p class="mt-3 flex-1 leading-relaxed text-slate-600 break-words">
                            {{ \Illuminate\Support\Str::limit($post->body, 150) }}
                        </p>
                        <div class="mt-5 flex flex-wrap gap-x-4 gap-y-1 border-t border-stone-100 pt-4 text-sm text-slate-500">
                            <span>{{ $post->published_at?->format('M j, Y') ?? 'Date unavailable' }}</span>
                            <span>{{ $post->comments_count }} {{ $post->comments_count === 1 ? 'comment' : 'comments' }}</span>
                        </div>
                    </article>
                @empty
                    <p class="rounded-xl border border-dashed border-stone-300 bg-white p-6 text-slate-600 md:col-span-2">
                        This author has no published posts yet.
                    </p>
                @endforelse
            </div>
        </section>
    </div>
@endsection
