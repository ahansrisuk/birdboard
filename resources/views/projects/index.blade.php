@extends('layouts.app')

@section('content')
    <header class="flex items-end justify-between mb-4">
        <h2 class="text-gray-700 text-xl">My Projects</h1>
        <a href="/projects/create" class="button">New Project</a>
    </header>

    <main class="flex flex-wrap -mx-3">
        @forelse ($projects as $project)
            <div class="w-1/3 px-3 pb-6">
                @include('projects.card') 
            </div>
        @empty
            <li>No projects yet.</li>
        @endforelse
    </main>
@endsection