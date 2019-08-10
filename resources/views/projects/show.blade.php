@extends('layouts.app')

@section('content')
    <header class="flex items-center mb-3 py-4">
        <div class="flex justify-between items-end w-full">
            <p class="text-grey text-md font-normal">
                <a href="{{ route('projects-index') }}" class="text-grey text-md font-normal no-underline">
                    My projects
                </a>/ {{ $project->title }}
            </p>
            <div class="flex items-center">
                @foreach($project->members as $member)
                    <img
                            src="={{  gravatar_url($member->email) }}"
                            alt="{{ $member->name }}'s avatar"
                            class="rounded-full w-8 mr-2">
                @endforeach

                <img
                        src="{{ gravatar_url($project->owner->email) }}"
                        alt="{{ $project->owner->name }}'s avatar"
                        class="rounded-full w-8 mr-2">

                <a href="{{ route('projects-create') }}" class="button ml-4">New Project</a>
            </div>
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

                    @if($errors->any())
                        <div class="filed mt-6">
                            @foreach($errors->all() as $error)
                                <li class="text-sm text-red">{{ $error }}</li>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <div class="lg:w-1/4 px-3 lg:py-8">
                @include('projects.card')
                @include('projects.activity.card')

                <div class="card flex flex-col mt-3" style="height: 200px;">
                    <h3 class="font-normal text-xl py-4 -ml-2 mb-3 pl-4" style="border-left: 4px solid #47cdff;">
                        Invite a User
                    </h3>

                    <form method="POST" action="{{ route('invitations-store', $project->id) }}" >
                        @csrf

                        <div class="mb-3">
                            <input type="email" name="email" class="border border-grey rounded w-full py-2 px-3" placeholder="Email adress">
                        </div>

                        <button type="submit" class="button">
                            Invite
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </main>
@endsection
