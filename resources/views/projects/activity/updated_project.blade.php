@if (count($activity->changes['after']) == 1)
    You updated {{ key($activity->changes['after']) }} of the project
@else
    You updated a project
@endif
