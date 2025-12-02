<?php

namespace App\Traits;

trait LogsMediaActivity
{
    /**
     * Log media addition
     *
     * @param string $fileName
     * @param string $collection
     * @return void
     */
    public function logMediaAddition(string $fileName, string $collection = 'images')
    {
        activity()
            ->performedOn($this)
            ->event('media_added')
            ->withProperties([
                'file_name' => $fileName,
                'collection' => $collection,
            ])
            ->log("Added media '{$fileName}' to {$this->getMediaLogDescription()}");
    }

    /**
     * Log media deletion
     *
     * @param string $fileName
     * @param string $collection
     * @return void
     */
    public function logMediaDeletion(string $fileName, string $collection = 'images')
    {
        activity()
            ->performedOn($this)
            ->event('media_deleted')
            ->withProperties([
                'file_name' => $fileName,
                'collection' => $collection,
            ])
            ->log("Deleted media '{$fileName}' from {$this->getMediaLogDescription()}");
    }

    /**
     * Get a description for media log entries
     * Can be overridden in individual models for custom descriptions
     *
     * @return string
     */
    protected function getMediaLogDescription(): string
    {
        // Try common naming patterns
        if (isset($this->title)) {
            return $this->title;
        }
        
        if (isset($this->name)) {
            return $this->name;
        }

        // Fallback to model class name and ID
        $modelName = class_basename($this);
        return "{$modelName} #{$this->id}";
    }
}
