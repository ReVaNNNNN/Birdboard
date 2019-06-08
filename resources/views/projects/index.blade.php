<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Birdboard</title>
</head>
<body>
    <h1>Birdboard</h1>

    @foreach($projects as $project)
        <li>{{ $project->title }}</li>
    @endforeach
</body>
</html>
