@extends('layouts.app')

@section('content')
    <header class="flex items-center mb-3 py-4">
        <div class="flex justify-between items-end w-full">
            <h2 class="text-grey text-md font-normal">Projects: </h2>
            <a href="#" class="button" @click="$modal.show('new-project')">New Project</a>
        </div>
    </header>

    <main class="lg:flex lg:flex-wrap -mx-3">
        @forelse($projects as $project)
            <div class="lg:w-1/3 px-3 pb-6 width30p">
                @include('projects.card')
            </div>
        @empty
            <div>There is no projects yet.</div>
        @endforelse
    </main>

    <new-project-modal></new-project-modal>
@endsection