<?php


namespace App;


trait RecordActivity
{
    /**
     * @param $description
     */
    public function recordActivity($description)
    {
        $this->activity()->create([
            'description' => $description,
            'changes' => $this->activityChanges(),
            'project_id' => 1 // complete it
        ]);
    }
}