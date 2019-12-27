@extends('layouts.app')

@section('content')
    <header class="flex items-end justify-between mb-4">
        <h2 class="text-gray-700 text-xl">My Projects</h1>
        <a href="/projects/create" class="button">New Project</a>
    </header>

    <main class="flex flex-wrap -mx-3">
        @forelse ($projects as $project)
            <div class="w-1/3 px-3 pb-6">
                <div class="bg-white p-5 rounded-lg shadow" style="height: 200px">
                    <h3 class="font-normal text-xl py-4 -ml-5 pl-4 border-l-4 border-blue-300 mb-2">
                        <a href="{{ $project->path() }}">{{ $project->title }}</a>
                    </h3>
                    <div class="text-gray-600">{{ Str::limit($project->description, 150) }}</div>
                </div>
            </div>
        @empty
            <li>No projects yet.</li>
        @endforelse
    </main>
@endsection