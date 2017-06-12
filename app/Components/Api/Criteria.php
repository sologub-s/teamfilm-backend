<?php
/**
 * Created by PhpStorm.
 * User: zeitgeist
 * Date: 5/3/17
 * Time: 4:24 PM
 */

namespace App\Components\Api;

class Criteria {

    /**
     * @var Array
     */
    protected $orderBy = [];

    /**
     * @var array
     */
    protected $filter = [];

    /**
     * @var int
     */
    protected $page = 1;

    /**
     * @var int
     */
    protected $limit = 20;

    /**
     * @var int
     */
    protected $count = 0;

    /**
     * @param $page
     */
    public function setPage ($page) {
        $this->page = is_null($page) || (int) $page < 1 ? 1 : (int) $page;
    }

    /**
     * @return int
     */
    public function getPage () {
        return $this->page;
    }

    /**
     * @param $limit
     */
    public function setLimit ($limit) {
        $this->limit = is_null($limit) || (int) $limit < 1 || (int) $limit > 100 ? 20 : (int) $limit;
    }

    /**
     * @return int
     */
    public function getLimit () {
        return $this->limit;
    }

    /**
     * @param Int $count
     */
    public function setCount(Int $count) {
        $this->count = $count;
    }

    /**
     * @return int
     */
    public function getCount() {
        return $this->count;
    }

    /**
     * @return int
     */
    public function getOffset() {
        return ($this->page - 1) * $this->limit;
    }

    /**
     * @return int
     */
    public function getTotalPages() {
        return (int) ceil($this->count / $this->limit);
    }

    /**
     * @param array|null $filter
     */
    public function setFilter($filter = [])
    {
        if (is_null($filter)) {
            return;
        }
        $this->filter = $this->parseFilter($filter);
    }

    /**
     * @param array|null $filter
     */
    public function addFilter($filter = [])
    {
        if (is_null($filter)) {
            return;
        }
        $this->filter = array_merge_recursive($this->filter, $this->parseFilter($filter));
    }

    /**
     * @return array
     */
    public function getFilter () {
        return $this->filter;
    }

    /**
     * @param array $filter
     * @return array
     */
    protected function parseFilter(Array $filter = [])
    {
        foreach($filter as $k => $v)
        {
            if (substr($v, 0, 6) == '__gt__') {
                $filter[$k] = ['$gt' => substr($v, 6)];
                continue;
            }
            if (substr($v, 0, 7) == '__gte__') {
                $filter[$k] = ['$gte' => substr($v, 7)];
                continue;
            }
            if (substr($v, 0, 6) == '__lt__') {
                $filter[$k] = ['$lt' => substr($v, 6)];
                continue;
            }
            if (substr($v, 0, 7) == '__lte__') {
                $filter[$k] = ['$lte' => substr($v, 7)];
                continue;
            }
            if (substr($v, 0, 6) == '__in__') {
                $filter[$k] = ['$in' => explode(',', substr($v, 6))];
                continue;
            }
            if (substr($v, 0, 7) == '__nin__') {
                $filter[$k] = ['$nin' => explode(',', substr($v, 7))];
                continue;
            }
        }
        return $filter;
    }

    /**
     * @param array|string|null $orderBy
     */
    public function setOrderBy($orderBy = [])
    {
        if (is_null($orderBy)) {
            return;
        }
        $this->orderBy = is_array($orderBy) ? $orderBy : $this->parseOrderBy($orderBy);
    }

    /**
     * @param array|string $orderBy
     */
    public function addOrderBy($orderBy = [])
    {
        if (is_null($orderBy)) {
            return;
        }
        $this->orderBy = array_merge_recursive($this->orderBy, is_array($orderBy) ? $orderBy : $this->parseOrderBy($orderBy));
    }

    /**
     * @return Array
     */
    public function getOrderBy()
    {
        return $this->orderBy;
    }

    /**
     * @param String $value
     * @return Array
     */
    protected function parseOrderBy(String $value) : Array
    {
        $exploded = explode(',', $value);
        $result = [];
        foreach($exploded as $item) {
            if(substr($item, 0, 1) == '-') {
                $result[substr($item, 1)] = -1;
                continue;
            }
            $result[$item] = 1;
        }
        return $result;
    }

    /**
     * @return array
     */
    public function toArray () {
        return [
            'page' => $this->getPage(),
            'totalPages' => $this->getTotalPages(),
            'limit' => $this->getLimit(),
            'offset' => $this->getOffset(),
            'count' => $this->getCount(),
        ];
    }

}