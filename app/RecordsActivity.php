<?php


namespace App;


trait RecordsActivity
{
    public $oldAttributes = [];

    /**
     * Boot the Trait.
     */
    public static function bootRecordsActivity()
    {
        $recordableEvents = static::$recordableEvents ?? ['created', 'updated'];

        foreach ($recordableEvents as $event) {
            static::$event(function ($model) use ($event) {

                $model->recordActivity($model->activityDescription($event));
            });
        }

        if ($event === 'updated') {
            static::updating(function ($model) {
                $model->oldAttributes = $model->getOriginal();
            });
        }
     }

    /**
     * @param string $description
     * @return string
     */
    protected function activityDescription($description): string
    {
        return "{$description}_" . strtolower(class_basename($this));
    }


    /**
     * @param $description
     */
    public function recordActivity($description)
    {
        $this->activity()->create([
            'user_id' => ($this->project ?? $this)->owner->id,
            'description' => $description,
            'changes' => $this->activityChanges(),
            'project_id' => class_basename($this) === 'Project' ? $this->id : $this->project_id
        ]);
    }

    /**
     * @return mixed
     */
    public function activity()
    {
        return $this->morphMany(Activity::class, 'subject')->latest();
    }

    /**
     * @return array
     */
    protected function activityChanges()
    {
        if ($this->wasChanged()) {
            return [
                'before' => array_except(array_diff($this->oldAttributes, $this->getAttributes()), 'updated_at'),
                'after' => array_except($this->getChanges(), 'updated_at')
            ];
        }
    }
}