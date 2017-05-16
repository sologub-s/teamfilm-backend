<?php

namespace App\Entities\Traits;

trait PrimaryKey
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @return Int|null
     */
    public function getId()
    {
        return $this->id;
    }
}