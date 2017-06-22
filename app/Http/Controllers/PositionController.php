<?php

namespace App\Http\Controllers;

use App\Models\Position;
use App\Services\UserService;
use Illuminate\Http\Response as Response;
use App\Components\Api\Exception as Exception;
use App\Components\Api\JsonController;
use App\Mappers\PositionMapper;
use App\Services\PositionService;

class PositionController extends JsonController
{

    /**
     * @param String $id
     * @return Response
     */
    public function get(String $id)
    {
        return $this->response([
            'position' => PositionMapper::execute(PositionService::get($id), 'api')->toArray(),
        ]);

    }

    /**
     * @return Response
     */
    public function getList()
    {
        $criteria = $this->getCriteria();
        $criteria->setCount(Position::count($criteria->getFilter()));
        return $this->response([
            'positions' => PositionMapper::execute(PositionService::getList($criteria), 'api')->toArray(),
            'criteria' => $criteria->toArray(),
        ]);

    }

    /**
     * @return Response
     */
    public function post ()
    {
        if ($this->getJsonParam('position')['user_id'] != $this->getUser()->id) {
            throw new Exception('', 403);
        }
        return $this->response([
            'position' => PositionMapper::execute(PositionService::create(new Position($this->getJsonParam('position'))), 'api')->toArray(),
        ]);
    }

    /**
     * @param String $id
     * @return Response
     */
    public function patch(String $id)
    {
        $this->allowDenyIfFound($id);
        return $this->response([
            'position' => PositionMapper::execute(PositionService::update($id, $this->getJsonParam('position')), 'api')->toArray(),
        ]);
    }

    /**
     * @param String $id
     * @return Response
     */
    public function delete(String $id)
    {
        $this->allowDenyIfFound($id);
        PositionService::delete($id);
        return $this->response();
    }

    public function apply(String $id)
    {
        if (!($user = UserService::get($this->getJsonParam('user')['id'] ))) {
            throw new Exception('', 403);
        }
        return $this->response([
            'success' => PositionService::apply($id, $user, $this->getJsonParam('letter')),
        ]);
    }

    public function accept(String $id)
    {
        $this->allowDenyIfFound($id);
        return $this->response([
            'success' => PositionService::setCompetitorStatus($id, $this->getJsonParam('user')['id'], 'accepted'),
        ]);
    }

    public function decline(String $id)
    {
        $this->allowDenyIfFound($id);
        return $this->response([
            'success' => PositionService::setCompetitorStatus($id, $this->getJsonParam('user')['id'], 'declined'),
        ]);
    }

    /**
     * @param String $id
     */
    protected function allowDenyIfFound (String $id) {
        if (is_null($position = PositionService::get($id))) {
            throw new Exception('Position not found', 404);
        }
        if ($this->getUser()->id != $position->user_id) {
            throw new Exception('', 403);
        }
    }

}
