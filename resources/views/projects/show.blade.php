@extends('layouts.app')
@section('content')
<header class="flex items-end justify-between mb-4">
    <p class="text-gray-700 text-sm">
        <a href="/projects">My Projects</a> / {{ $project->title }}
    </p>
    <a href="/projects/create" class="button">New Project</a>
</header>

<main>
    <div class="flex -mx-3">
        <div class="w-3/4 px-3">
            <div class="mb-8">
                <h2 class="text-gray-700 mb-3">Tasks</h1>
                    {{-- Tasks--}}
                <div class="card">aofabwfuoabfuoabsfkjanwfobauofbakjwfb.</div>
            </div>
            <div class="mb-8">
                <h2 class="text-gray-700 mb-3">Notes</h1>
                    {{-- Notes --}}
                <textarea class="card w-full" style="min-height: 200px">aofabwfuoabfuoabsfkjanwfobauofbakjwfb.</textarea w-full>
            </div>
        </div>
        <div class="w-1/4 px-3">
           @include('projects.card') 
        </div>
    </div>
</main>

   <a href="/projects">Go Back</a>
@endsection