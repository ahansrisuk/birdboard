<div class="card" style="height: 200px">
    <h3 class="font-normal text-xl py-4 -ml-5 pl-4 border-l-4 border-blue-300 mb-2">
        <a href="{{ $project->path() }}">{{ $project->title }}</a>
    </h3>
    <div class="text-gray-600">{{ Str::limit($project->description, 150) }}</div>
</div>