<?php

namespace App\Entities;

use Doctrine\ORM\Mapping as ORM;

abstract class AbstractEntity
{
    /**
     * AbstractEntity constructor.
     * @param array|null $data Array to hydrate
     */
    public function __construct(Array $data = null) {
        $this->setCreatedAt(new \DateTime());
        $this->setUpdatedAt(new \DateTime());
        if ($data) {
            $this->hydrateArray($data);
        }
    }

    /**
     * @ORM\PreUpdate
     */
    public function setUpdatedAtValue() {
        $this->setUpdatedAt(new \DateTime());
    }

    /**
     * @return Array
     */
    abstract public function getFields() : Array;

    /**
     * @param array $data
     */
    public function hydrateArray(Array $data)
    {
        foreach ($this->getFields() as $field) {

            if (!array_key_exists($field, $data)) {
                continue;
            }

            $this->{'set'.ucfirst($field)}($data[$field]);
        }
    }

    /**
     * @return Array
     */
    public function toArray() : Array
    {
        $array = [];
        foreach ($this->getFields() as $field) {
            $array[$field] = $this->{'get'.ucfirst($field)}();
        }
        return $array;
    }

    /**
     * @return bool
     */
    abstract public function isValid() : bool;
}