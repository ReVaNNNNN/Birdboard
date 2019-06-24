@extends('layouts.app')

@section('content')
    <header class="flex items-center mb-3 py-4">
        <div class="flex justify-between items-end w-full">
            <p class="text-grey text-md font-normal">
                <a href="{{ route('projects-index') }}" class="text-grey text-md font-normal no-underline">
                    My projects
                </a>/ {{ $project->title }}
            </p>
            <a href="{{ route('projects-create') }}" class="button">New Project</a>
        </div>
    </header>

    <main>
        <div class="lg:flex -mx-3">
            <div  class="lg:w-3/4 px-5 mb-6">
                <div class="mb-8">
                    <h2 class="text-lg text-grey font-normal mb-3">Tasks</h2>
                    {{-- tasks --}}
                    @foreach($project->tasks as $task)
                        <div class="card mb-3">
                            <form action="{{ route('task-update', [$project->id, $task->id]) }}">
                                @method('PATCH')
                                @csrf

                                <div class="flex">
                                    <input
                                            value="{{ $task->body }}"
                                            name="body"
                                            class="w-full border-0 {{ $task->completed ? 'text-grey' : ''}}"
                                    />
                                    <input
                                        type="checkbox"
                                        name="completed"
                                        onChange="this.form.submit()"
                                        {{$task->completed ? 'checked' : ''}}
                                    />
                                </div>
                            </form>
                        </div>
                    @endforeach

                    <div class="card mb-3">
                        <form action="{{ route('task-create', $project->id) }}" method="POST">
                            @csrf

                            <input placeholder="Add a new task..." class="w-full border-0" name="body">
                        </form>
                    </div>
                </div>

                <div>
                    <h2 class="text-lg text-grey font-normal mb-3">General Notes</h2>

                    <form method="POST" action=" {{route('projects-show', $project->id)}}">
                        @csrf
                        @method('PATCH')
                        <textarea name="notes" class="card w-full mb-4" style="min-height: 200px"
                                  placeholder="Write up that box...">{{ $project->notes }}</textarea>
                        <button type="submit" class="button">Save</button>
                    </form>
                </div>
            </div>

            <div class="lg:w-1/4 px-5">
                @include('projects.card')
            </div>
        </div>
    </main>
@endsection
