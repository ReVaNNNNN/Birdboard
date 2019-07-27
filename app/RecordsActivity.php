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
        static::updating(function ($model) {
            $model->oldAttributes = $model->getOriginal();
        });

        $recordableEvents = static::$recordableEvents ?? ['created', 'updated', 'deleted'];

        foreach ($recordableEvents as $event) {
            static::$event(function ($model) use ($event) {
               if (class_basename($model) !== 'Project') {
                   $event = "{$event}_" . strtolower(class_basename($model));
               }

               $model->recordActivity($event);
            });
        }
    }
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