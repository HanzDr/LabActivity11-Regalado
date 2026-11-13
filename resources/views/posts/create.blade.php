@extends('layouts.app')

@section('content')
    <div class="mx-auto max-w-3xl">
        <a href="{{ route('posts.index') }}" class="mb-6 inline-block font-medium text-emerald-800 underline underline-offset-4 hover:text-emerald-950">
            ← Back to all posts
        </a>

        <div class="rounded-xl border border-stone-200 bg-white p-6 shadow-sm sm:p-8">
            <p class="mb-2 text-sm font-semibold uppercase tracking-wide text-emerald-700">Community bulletin</p>
            <h1 class="text-3xl font-bold tracking-tight">Create a new post</h1>

            @if ($errors->any())
                <div class="mt-6 rounded-lg border border-red-200 bg-red-50 p-4 text-sm text-red-800" role="alert">
                    <p class="font-semibold">Please fix the following errors:</p>
                    <ul class="mt-2 list-disc space-y-1 pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('posts.store') }}" class="mt-6 space-y-6">
                @csrf

                <div>
                    <label for="title" class="mb-2 block text-sm font-medium">Title</label>
                    <input id="title" type="text" name="title" value="{{ old('title') }}" required maxlength="120" class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:border-emerald-700 focus:outline-2 focus:outline-emerald-700">
                    @error('title')
                        <p class="mt-1 text-sm text-red-700">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="body" class="mb-2 block text-sm font-medium">Body</label>
                    <textarea id="body" name="body" rows="8" required class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:border-emerald-700 focus:outline-2 focus:outline-emerald-700">{{ old('body') }}</textarea>
                    @error('body')
                        <p class="mt-1 text-sm text-red-700">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="category" class="mb-2 block text-sm font-medium">Category</label>
                    <select id="category" name="category" required class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:border-emerald-700 focus:outline-2 focus:outline-emerald-700">
                        <option value="">Select a category</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category }}" @selected(old('category') === $category)>{{ $category }}</option>
                        @endforeach
                    </select>
                    @error('category')
                        <p class="mt-1 text-sm text-red-700">{{ $message }}</p>
                    @enderror
                </div>

                <fieldset>
                    <legend class="text-sm font-medium">Tags</legend>
                    <div class="mt-2 grid gap-2 sm:grid-cols-2">
                        @foreach ($tags as $tag)
                            <label class="flex items-center gap-2 text-sm">
                                <input
                                    type="checkbox"
                                    name="tags[]"
                                    value="{{ $tag->id }}"
                                    @checked(in_array($tag->id, old('tags', [])))
                                    class="rounded border-slate-300 text-emerald-800 focus:ring-emerald-700"
                                >
                                {{ $tag->name }}
                            </label>
                        @endforeach
                    </div>
                    @error('tags')
                        <p class="mt-1 text-sm text-red-700">{{ $message }}</p>
                    @enderror
                    @error('tags.*')
                        <p class="mt-1 text-sm text-red-700">{{ $message }}</p>
                    @enderror
                </fieldset>

                <div>
                    <label class="flex items-center gap-2 text-sm font-medium">
                        <input type="hidden" name="is_published" value="0">
                        <input type="checkbox" name="is_published" value="1" @checked(old('is_published', false)) class="rounded border-slate-300 text-emerald-800 focus:ring-emerald-700">
                        Publish immediately
                    </label>
                    @error('is_published')
                        <p class="mt-1 text-sm text-red-700">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="rounded-lg bg-emerald-800 px-5 py-2.5 font-semibold text-white hover:bg-emerald-900 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-emerald-800">
                    Create post
                </button>
            </form>
        </div>
    </div>
@endsection
