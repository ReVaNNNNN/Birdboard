<div class="card" style="height: 200px;">
    <h3 class="font-normal text-xl py-4 -ml-2 mb-3 pl-4" style="border-left: 4px solid #47cdff;">
        <a href=" {{ $project->path() }}" class="text-black no-underline">{{ $project->title }}</a>
    </h3>

    <div class="text-grey mb-4">{{ str_limit($project->description, 200) }}</div>

    <footer>
        <form method="POST" action="{{ route('projects-destroy', $project->id) }}" class="text-right">
            @method('DELETE')
            @csrf
            <button type="submit" class="text-xs">
                Delete
            </button>
        </form>
    </footer>
</div>
