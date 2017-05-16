<?php

namespace App\Components\Api;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request as Request;
use Illuminate\Http\Response as Response;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ManagerRegistry;

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
}