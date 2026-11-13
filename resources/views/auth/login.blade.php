@extends('layouts.app')

@section('content')
    <div class="mx-auto max-w-md">
        <div class="rounded-xl border border-stone-200 bg-white p-6 shadow-sm sm:p-8">
            <p class="mb-2 text-sm font-semibold uppercase tracking-wide text-emerald-700">Resident access</p>
            <h1 class="text-3xl font-bold tracking-tight">Log in</h1>
            <p class="mt-3 text-slate-600">Sign in to your Barangay Bulletin account.</p>

            @if ($errors->any())
                <div class="mt-6 rounded-lg border border-red-200 bg-red-50 p-4 text-sm text-red-800" role="alert">
                    <p class="font-semibold">Please check your details.</p>
                    <ul class="mt-2 list-disc space-y-1 pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ url('/login') }}" class="mt-6 space-y-5">
                @csrf

                <div>
                    <label for="email" class="mb-2 block text-sm font-medium">Email</label>
                    <input
                        id="email"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        autofocus
                        autocomplete="email"
                        class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 focus:border-emerald-700 focus:outline-2 focus:outline-emerald-700"
                    >
                </div>

                <div>
                    <label for="password" class="mb-2 block text-sm font-medium">Password</label>
                    <input
                        id="password"
                        type="password"
                        name="password"
                        required
                        autocomplete="current-password"
                        class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 focus:border-emerald-700 focus:outline-2 focus:outline-emerald-700"
                    >
                </div>

                <button type="submit" class="w-full rounded-lg bg-emerald-800 px-5 py-2.5 font-semibold text-white hover:bg-emerald-900 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-emerald-800">
                    Log in
                </button>
            </form>
        </div>
    </div>
@endsection
