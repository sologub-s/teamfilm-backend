<?php

namespace App\Services;

use App\Components\Api\Exception;
use App\Components\Api\Criteria;
use App\Entities\User;
use App\Exceptions\EntityNotFoundException;
use App\Exceptions\InvalidEntityException;
use \App\Models\Position;
use App\Mappers\PositionMapper;

use \Illuminate\Support\Facades\Validator;

class PositionService extends AbstractService
{
    /**
     * @param \App\Models\AbstractModel $position
     * @return TRUE|array TRUE if valid, otherways array of errors
     */
    public static function isValid(\App\Models\AbstractModel $position)
    {
        $validator = Validator::make(PositionMapper::execute($position, 'service')->toArray(), [

            'user_id' => 'string|nullable|mongoid',
            'project_id' => 'string|nullable|mongoid',
            'created_at' => 'int|required',
            'updated_at' => 'int|required',
            'title' => 'string|max:255|required',
            'position' => 'required_without:position_custom|in:'.implode(',', Position::$_positions),
            'position_custom' => 'string|max:255|required_without:position',
            'requirements' => 'string|required',
            'sex' => 'string|size:1|nullable|in:m,w',
            'work_experience' => 'int|min=0',
            'is_paid' => 'boolean|required',
            'tax_type' => 'in:'.implode(',', Position::$_tax_types),
            'competitors' => 'array',
            'amount' => 'int|min=1',
            'applied' => 'int|min=0',
            'published' => 'boolean|required',
            'completed' => 'boolean|required',
        ]);
        return $validator->fails() ? $validator->errors()->all() : true;
    }

    /**
     * @param String|null $id
     * @return Position|null
     */
    public static function get (String $id = null) {
        if (!$position = Position::fetchOne(['id' => $id])) {
            throw new \App\Exceptions\EntityNotFoundException('Position not found');
        }
        return $position;
    }

    /**
     * @param Position $position
     * @return Position
     */
    public static function create(Position $position) : Position
    {

        if(!($user = \App\Services\UserService::get($position->user_id))) {
            throw new Exception('User not found', 404);
        }

        if(!($project = \App\Services\ProjectService::get($position->project_id))) {
            throw new Exception('Project not found', 404);
        }

        if($project->user_id !== $user->id) {
            throw new Exception('Project does not belong to user', 403);
        }

        $position->created_at = $position->updated_at = time();
        $position->published = isset($position->published) ? $position->published : false;

        if (TRUE !== self::isValid($position)) {
            throw new \App\Exceptions\InvalidEntityException('Position data validation errors: '.implode('; ', self::isValid($position)));
        }
        try {
            $position->save();
        } catch (\Exception $e) {
            throw new \App\Exceptions\CannotSaveEntityException('Position cannot be saved');
        }

        return $position;
    }

    /**
     * @param String $id
     * @param array $data
     * @return Position
     * @throws \App\Exceptions\CannotSaveEntityException
     * @throws \App\Exceptions\EntityNotFoundException
     * @throws \App\Exceptions\InvalidEntityException
     */
    public static function update(String $id, Array $data = []) : Position
    {
        if (!$position = Position::fetchOne(['id' => $id])) {
            throw new \App\Exceptions\EntityNotFoundException('Position not found');
        }

        $position->updated_at = time();
        foreach (['_id','user_id','project_id',] as $k) {
            if (isset($data[$k])) {
                unset($data[$k]);
            }
        }
        $position->populate($data);

        if (TRUE !== self::isValid($position)) {
            throw new \App\Exceptions\InvalidEntityException('Position data is not valid');
        }

        try {
            $position->save();
        } catch (\Exception $e) {
            throw new \App\Exceptions\CannotSaveEntityException('Position cannot be saved');
        }

        return $position;
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

        if (!$position = Position::fetchOne(['id' => $id])) {
            throw new \App\Exceptions\EntityNotFoundException('Position not found');
        }

        try {
            $position->remove();
        } catch (\Exception $e) {
            throw new \App\Exceptions\CannotRemoveEntityException('Position cannot be deleted');
        }
    }

    /**
     * @param String|null $user_id
     * @return [Position]|null
     */
    public static function getList (Criteria $criteria) {
        return Position::fetchAll($criteria->getFilter(), $criteria->getOrderBy(), $criteria->getLimit(), $criteria->getOffset());
    }

    /**
     * @param String $positionId
     * @param User $user User
     * @param String $letter
     * @return bool
     * @throws EntityNotFoundException
     * @throws \App\Exceptions\CannotSaveEntityException
     */
    public static function apply(String $positionId, User $user, String $letter)
    {
        if (!$position = Position::fetchOne(['id' => $positionId])) {
            throw new \App\Exceptions\EntityNotFoundException('Position not found');
        }

        $position->updated_at = time();

        foreach ($position->competitors as $competitor) {
            if ($competitor['user_id'] == $user->id) {
                return false;
            }
        }

        $position->competitors[] = [
            'user_id' => $user->id,
            'letter' => $letter,
            'status' => 'pending',
        ];

        try {
            $position->save();
        } catch (\Exception $e) {
            throw new \App\Exceptions\CannotSaveEntityException('Position cannot be saved');
        }

        return true;

    }

    public static function setCompetitorStatus(String $positionId, String $userId, String $status)
    {
        if (!$position = Position::fetchOne(['id' => $positionId])) {
            throw new \App\Exceptions\EntityNotFoundException('Position not found');
        }

        if(!in_array($status, ['accepted','declined'])) {
            throw new Exception('400', "Impossible status '".$status."'");
        }

        $position->updated_at = time();

        foreach ($position->competitors as $k => $competitor) {
            if ($competitor['user_id'] == $userId) {
                $position->competitors[$k]['status'] = $status;
                try {
                    $position->save();
                } catch (\Exception $e) {
                    throw new \App\Exceptions\CannotSaveEntityException('Position cannot be saved');
                }

                return true;
            }
        }
        return false;
    }

}