<?php

namespace App\Mappers;

class ProjectMapper extends \MongoStar\Map
{
    /**
     * @return array
     */
    public function common() : array
    {
        return [
            'id' => 'uid',
        ];
    }

    public function service () : array
    {
        return [
            'id' => 'id',
            'user_id' => 'user_id',
            'title' => 'title',
            'description' => 'description',
            'created_at' => 'created_at',
            'updated_at' => 'updated_at',
            'type' => 'type',
            'genres' => 'genres',
            'genres_custom' => 'genres_custom',
            'start_date' => 'start_date',
            'deadline_date' => 'deadline_date',
            'duration' => 'duration',
            'logo' => 'logo',
            'country' => 'country',
            'city' => 'city',
            'place' => 'place',
            'status' => 'status',
        ];
    }

    public function api()
    {
        return $this->service();
    }

    public function getGenres ($project) : array {
        return is_array($project->genres) ? $project->genres : [];
    }
}