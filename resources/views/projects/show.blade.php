@extends('layouts.app')

@section('content')
<body>
<h1>{{ $project->title }}</h1>
<div>{{ $project->description }}</div>
<a href="{{ route('projects-index') }}">Go back</a>
</body>
@endsection
