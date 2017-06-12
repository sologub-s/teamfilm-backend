<?php

namespace App\Services;

use App\Components\Api\Exception;
use App\Components\Api\Criteria;
use App\Exceptions\EntityNotFoundException;
use App\Exceptions\InvalidEntityException;
use \App\Models\Project;
use App\Mappers\ProjectMapper;

use \Illuminate\Support\Facades\Validator;

class ProjectService extends AbstractService
{
    /**
     * @param \App\Models\AbstractModel $project
     * @return TRUE|array TRUE if valid, otherways array of errors
     */
    public static function isValid(\App\Models\AbstractModel $project)
    {
        $validator = Validator::make(ProjectMapper::execute($project, 'service')->toArray(), [

            'user_id' => 'string|nullable|mongoid',
            'title' => 'string|max:255|required',
            'description' => 'string|nullable',
            'created_at' => 'int|required',
            'updated_at' => 'int|required',
            'type' => 'string|in:'.implode(',', Project::$_types),
            'genres' => 'filteredarray:'.implode(',', Project::$_genres),
            'genres_custom' => 'string|nullable',
            'start_date' => 'int|required',
            'deadline_date' => 'int|required',
            'duration' => 'int|required',
            'country' => 'string|nullable|mongoid',
            'city' => 'string|nullable|mongoid',
            'place' => 'string|required',
            'status' => 'in:'.implode(',', Project::$_statuses),
        ]);
        return $validator->fails() ? $validator->errors()->all() : true;
    }

    /**
     * @param array|null $logo
     * @return bool
     */
    public static function isValidLogo(Array $logo = null)
    {
        if (!is_array($logo)) {
            return false;
        }
        $validator = Validator::make($logo, [
            'identity' => 'string|size:32|required',
            'type' => 'string|nullable',
            'size' => 'int|required',
            'url' => 'string|required',
        ]);
        return $validator->fails() ? $validator->errors()->all() : true;
    }

    /**
     * @param String|null $id
     * @return Project|null
     */
    public static function get (String $id = null) {
        if (!$project = Project::fetchOne(['id' => $id])) {
            throw new \App\Exceptions\EntityNotFoundException('Project not found');
        }
        return $project;
    }

    /**
     * @param Project $project
     * @return Project
     */
    public static function create(Project $project) : Project
    {

        if(!\App\Services\UserService::get($project->user_id)) {
            throw new Exception('User not found', 404);
        }

        $project->created_at = $project->updated_at = time();
        $project->status = 'on_hold';

        if (TRUE !== self::isValid($project)) {
            throw new \App\Exceptions\InvalidEntityException('Project data validation errors: '.implode('; ', self::isValid($project)));
        }
        try {
            $project->save();
        } catch (\Exception $e) {
            throw new \App\Exceptions\CannotSaveEntityException('Project cannot be saved');
        }

        return $project;
    }

    /**
     * @param String $id
     * @param array $data
     * @return Project
     * @throws \App\Exceptions\CannotSaveEntityException
     * @throws \App\Exceptions\EntityNotFoundException
     * @throws \App\Exceptions\InvalidEntityException
     */
    public static function update(String $id, Array $data = []) : Project
    {
        if (!$project = Project::fetchOne(['id' => $id])) {
            throw new \App\Exceptions\EntityNotFoundException('Project not found');
        }

        $project->updated_at = time();
        foreach (['_id','user_id',] as $k) {
            if (isset($data[$k])) {
                unset($data[$k]);
            }
        }
        $project->populate($data);

        if (TRUE !== self::isValid($project)) {
            throw new \App\Exceptions\InvalidEntityException('Project data is not valid');
        }

        if ($project->logo && TRUE !== self::isValidLogo($project->logo)) {
            throw new \App\Exceptions\InvalidEntityException('Logo data is not valid');
        }

        try {
            $project->save();
        } catch (\Exception $e) {
            throw new \App\Exceptions\CannotSaveEntityException('Project cannot be saved');
        }

        return $project;
    }

    /**
     * @param String $id
     * @return void
     * @throws \App\Exceptions\CannotSaveEntityException
     * @throws \App\Exceptions\EntityNotFoundException
     * @throws \App\Exceptions\InvalidEntityException
     */
    public static function delete(String $id) : void
    {

        if (!$project = Project::fetchOne(['id' => $id])) {
            throw new \App\Exceptions\EntityNotFoundException('Project not found');
        }

        try {
            $project->remove();
        } catch (\Exception $e) {
            throw new \App\Exceptions\CannotRemoveEntityException('Project cannot be deleted');
        }
    }

    /**
     * @param String $id Project id
     * @return array
     * @throws EntityNotFoundException
     * @throws InvalidEntityException
     * @throws \App\Exceptions\CannotSaveEntityException
     */
    public static function setLogo(String $id) : array {

        if (!$project = Project::fetchOne(['id' => $id])) {
            throw new \App\Exceptions\EntityNotFoundException('Project not found');
        }

        $logo = resolve('\Storage\Storage')->upload('logo', \Storage\Storage::FILES)[0]->asArray();
        if (TRUE !== self::isValidLogo($logo)) {
            throw new \App\Exceptions\InvalidEntityException('Logo data is not valid');
        }

        $logoImagick = new \Imagick((config('services.storage.url') . $logo['url']));
        $logo['width'] = $logoImagick->getImageWidth();
        $logo['height'] = $logoImagick->getImageHeight();

        $project->logo = $logo;
        try {
            $project->save();
        } catch (\Exception $e) {
            throw new \App\Exceptions\CannotSaveEntityException('Project cannot be saved');
        }

        return $logo;
    }

    /**
     * @param String $id
     * @return bool
     * @throws \App\Exceptions\CannotRemoveEntityException
     * @throws \App\Exceptions\EntityNotFoundException
     */
    public static function deleteLogo(String $id) : bool {

        if (!$project = Project::fetchOne(['id' => $id])) {
            throw new \App\Exceptions\EntityNotFoundException('Project not found');
        }

        if (!$project->logo) {
            return true;
        }

        if ($project->logo && !self::isValidLogo($project->logo)) {
            throw new \App\Exceptions\InvalidEntityException('Logo data is not valid');
        }

        try {
            if($project->logo) {
                resolve('\Storage\Storage')->delete($project->logo['identity']);
                $project->logo = null;
            }
            $project->save();
        } catch (\Exception $e) {
            throw new \App\Exceptions\CannotRemoveEntityException('Logo cannot be deleted or project cannot be updated');
        }

        return true;

    }

    /**
     * @param String|null $id
     * @return Project|null
     */
    public static function getById (String $id = null) {
        return Project::fetchOne(['id' => $id]);
    }

    /**
     * @param String|null $user_id
     * @return [Project]|null
     */
    public static function getList (Criteria $criteria) {
        return Project::fetchAll($criteria->getFilter(), $criteria->getOrderBy(), $criteria->getLimit(), $criteria->getOffset());
    }

}