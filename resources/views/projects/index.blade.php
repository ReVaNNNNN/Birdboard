@extends('layouts.app')

@section('content')
    <div class="flex items-center mb-4">
        <h1 class="mr-auto">Birdboard</h1>
        <a href="{{ route('projects-create') }}">New Project</a>
    </div>
    @forelse($projects as $project)
        <li>
            <a href="{{ $project->path() }}"> {{ $project->title }} </a>
        </li>
    @empty
        <li>No projects yet.</li>
    @endforelse
@endsection

