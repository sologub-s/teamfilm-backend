<?php

namespace App\Components\Api;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request as Request;
use Illuminate\Http\Response as Response;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ManagerRegistry;
use App\Services\UserService;

abstract class JsonController extends BaseController
{
    protected $em;

    /**
     * JsonController constructor.
     * @param ManagerRegistry $em
     */
    public function __construct(ManagerRegistry $em)
    {
        $this->em = $em;
    }

    /**
     * @return ObjectManager
     */
    protected function getOm() : ObjectManager
    {
        return $this->em->getManager();
    }

    /**
     * @param array $data
     * @param Int $code
     * @param null $message
     * @return Response
     */
    protected function response (Array $data = [], Int $code = Response::HTTP_OK, $message = null) {
        return response()->json($data)->setStatusCode($code, $message || Response::$statusTexts[$code]);
    }

    protected function getParam (String $paramName = null) {
        return request()->route()->parameter($paramName, null);
    }

    protected function getJson () {
        return request()->json()->all();
    }

    protected function getJsonParam (String $paramName = null) {
        return request()->json($paramName, null);
    }

    protected function getUser () {
        return request()->header('X-Auth', null) ? UserService::getUserByAccessToken(request()->header('X-Auth'), true) : null;
    }

    /**
     * @return Criteria
     */
    protected function getCriteria() {
        $params = request()->only(['order_by','filter','page','limit',]);
        $criteria = new \App\Components\Api\Criteria();
        $criteria->setOrderBy($params['order_by']);
        $criteria->setFilter($params['filter']);
        $criteria->setPage($params['page']);
        $criteria->setLimit($params['limit']);
        return $criteria;
    }
}