<?php

namespace App\Mappers;

class PositionMapper extends \MongoStar\Map
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
            'project_id' => 'project_id',
            'title' => 'title',
            'position' => 'position',
            'position_custom' => 'position_custom',
            'requirements' => 'requirements',
            'sex' => 'sex',
            'work_experience' => 'work_experience',
            'is_paid' => 'is_paid',
            'tax_type' => 'tax_type',
            'competitors' => 'competitors',
            'amount' => 'amount',
            'applied' => 'applied',
            'published' => 'published',
            'completed' => 'completed',
        ];
    }

    public function api()
    {
        return $this->service();
    }

    public function getCompetitors ($position) : array {
        return is_array($position->competitors) ? $position->competitors : [];
    }
}