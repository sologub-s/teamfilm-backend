<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Response as Response;
use App\Components\Api\Exception as Exception;
use App\Components\Api\JsonController;
use App\Mappers\ProjectMapper;
use App\Services\ProjectService;

class ProjectController extends JsonController
{

    /**
     * @param String $id
     * @return Response
     */
    public function get(String $id)
    {
        return $this->response([
            'project' => ProjectMapper::execute(ProjectService::get($id), 'api')->toArray(),
        ]);

    }

    /**
     * @return Response
     */
    public function getList()
    {
        $criteria = $this->getCriteria();
        $criteria->setCount(Project::count($criteria->getFilter()));
        return $this->response([
            'projects' => ProjectMapper::execute(ProjectService::getList($criteria), 'api')->toArray(),
            'criteria' => $criteria->toArray(),
        ]);

    }

    /**
     * @return Response
     */
    public function post ()
    {
        if ($this->getJsonParam('project')['user_id'] != $this->getUser()->id) {
            throw new Exception('', 403);
        }
        return $this->response([
            'project' => ProjectMapper::execute(ProjectService::create(new Project($this->getJsonParam('project'))), 'api')->toArray(),
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
            'project' => ProjectMapper::execute(ProjectService::update($id, $this->getJsonParam('project')), 'api')->toArray(),
        ]);
    }

    /**
     * @param String $id
     * @return Response
     */
    public function delete(String $id)
    {
        $this->allowDenyIfFound($id);
        ProjectService::delete($id);
        return $this->response();
    }

    /**
     * @param String $id
     * @return Response
     */
    public function getLogo(String $id)
    {
        return $this->response([
            'logo' => ProjectMapper::execute(ProjectService::get($id), 'api')->toArray()['logo'],
        ]);

    }

    /**
     * @param String $id
     * @return Response
     */
    public function postLogo (String $id) {
        $this->allowDenyIfFound($id);
        return $this->response([
            'logo' => ProjectService::setLogo($id)
        ]);
    }

    /**
     * @param String $id
     * @return Response
     */
    public function deleteLogo (String $id) {
        $this->allowDenyIfFound($id);
        ProjectService::deleteLogo($id);
        return $this->response();
    }

    /**
     * @param String $id
     */
    protected function allowDenyIfFound (String $id) {
        if (is_null($project = ProjectService::get($id))) {
            throw new Exception('Project not found', 404);
        }
        if ($this->getUser()->id != $project->user_id) {
            throw new Exception('', 403);
        }
    }

}
