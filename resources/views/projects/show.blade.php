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
                    <div class="card">Lorem ipsum.</div>
                </div>

                <div>
                    <h2 class="text-lg text-grey font-normal mb-3">General Notes</h2>
                    {{-- general notes --}}
                    <textarea class="card w-full" style="min-height: 200px">Lorem ipsum.</textarea>
                </div>
            </div>

            <div class="lg:w-1/4 px-5">
                @include('projects.card')
            </div>
        </div>
    </main>
@endsection
