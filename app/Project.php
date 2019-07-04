<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        \App\Project::created(function ($project) {
            \App\Activity::create([
                'project_id' => $project->id,
                'description' => 'created'
            ]);
        });

        \App\Project::updated(function ($project) {
            \App\Activity::create([
                'project_id' => $project->id,
                'description' => 'updated'
            ]);
        });
    }

    protected $guarded = [];

    public function path()
    {
        return "projects/{$this->id}";
    }

    public function owner()
    {
        return $this->belongsTo(User::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function addTask($body)
    {
        return $this->tasks()->create(compact('body'));
    }

    public function activity()
    {
        return $this->hasMany(Activity::class);
    }
}
