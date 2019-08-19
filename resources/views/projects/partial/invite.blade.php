<div class="card flex flex-col mt-3">
    <h3 class="font-normal text-xl py-4 -ml-2 mb-3 pl-4" style="border-left: 4px solid #47cdff;">
        Invite a User
    </h3>

    <form method="POST" action="{{ route('invitations-store', $project->id) }}" >
        @csrf

        <div class="mb-3">
            <input type="email" name="email" class="border border-grey rounded w-full py-2 px-3" placeholder="Email address">
        </div>

        <button type="submit" class="button">
            Invite
        </button>
    </form>

    @include('projects.partial.errors', ['bag' => 'invitations'])
</div>