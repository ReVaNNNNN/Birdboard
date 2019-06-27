@extends('layouts.app')

@section('content')
    <body>
        <form method="POST" action="{{ route('projects-update', $project->id) }}">
            @csrf
            @method('PATCH')

            <h1 class="heading is-1">Edit Your  Project</h1>

            <div class="field">
                <label for="title" class="label">Title</label>

                <div class="control">
                    <input
                            type="text"
                            class="input"
                            name="title"
                            placeholder="Title"
                            value=" {{ $project->title }}"
                    >
                </div>
            </div>

            <div class="field">
                <label for="description" class="label">Description</label>

                <div class="control">
                    <textarea class="textarea" name="description">
                        {{ $project->description }}
                    </textarea>
                </div>
            </div>

            <div class="field">
                <div class="control">
                    <button type="submit" class="button is-link">Update project</button>
                    <a href="{{ route('projects-show', $project->id) }}">Cancel</a>
                </div>
            </div>
        </form>
    </body>
@endsection