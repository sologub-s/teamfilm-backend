<?php

namespace App\Models;

abstract class AbstractModel extends \MongoStar\Model
{

    /**
     * AbstractModel constructor.
     * @param array|null $data
     */
    public function __construct(array $data = null)
    {
        parent::__construct();

        if ($data) {
            $this->populate($data);
        }
    }

}