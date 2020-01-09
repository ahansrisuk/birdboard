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
                    @forelse ($project->tasks as $task)

                    <div class="card mb-3">
                        <form method="post" action="{{ $task->path() }}">
                            @method('PATCH')
                            @csrf
                            <div class="flex items-center">
                                <input name="body" value="{{ $task->body }}" class="w-full {{ $task->completed ? 'text-gray-500' : ''}}">
                                <input name="completed" type="checkbox" onChange="this.form.submit()" {{ $task->completed ? 'checked' : ''}}>
                            </div>
                        </form>
                    </div>
                    @empty
                    @endforelse
                    <div class="card mb-3">
                        <form action="{{ $project->path() . '/tasks' }}" method="post">
                            @csrf
                            <input placeholder="Add a new task..." class="w-full" name="body">
                        </form>
                    </div>
            </div>
            <div class="mb-8">
                <h2 class="text-gray-700 mb-3">Notes</h1>
                    {{-- Notes --}}
                    <form method="post" action="{{ $project->path() }}">
                        @csrf
                        @method('PATCH')
                        <textarea name="notes" class="card w-full mb-4" style="min-height: 200px" placeholder="Enter your notes here...">
                            {{ $project->notes }}
                        </textarea w-full>
                        <button type="submit" class="button">Save</button>
                    </form>
            </div>
        </div>
        <div class="w-1/4 px-3">
           @include('projects.card') 
        </div>
    </div>
</main>

   <a href="/projects">Go Back</a>
@endsection