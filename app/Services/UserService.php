<?php

namespace App\Services;

use App\Components\Api\Exception;
use \App\Models\User;
use App\Mappers\UserMapper;

use \Illuminate\Support\Facades\Validator;

class UserService extends AbstractService
{
    /**
     * @param \App\Models\AbstractModel $user
     * @return TRUE|array TRUE if valid, otherways array of errors
     */
    public static function isValid(\App\Models\AbstractModel $user)
    {
        $validator = Validator::make(UserMapper::execute($user, 'validate')->toArray(), [
            'email' => 'email|max:255|required|string',
            'password' => 'string|size:60|required',
            'created_at' => 'int|required',
            'updated_at' => 'int|required',
            'activated_at' => 'int|nullable',
            'is_active' => 'boolean|required',
            'activation_token' => 'string|alpha_num|size:13|required',
            'name' => 'string|max:255|required|alpha_dash',
            'surname' => 'string|max:255|required|alpha_dash',
            'nickname' => 'string|max:255|required|alpha_dash',
            'cellphone' => 'string|max:20|nullable|phone:AUTO',
            'sex' => 'string|size:1|nullable|in:m,w',
            'birthday' => 'int|nullable',
            'country' => 'string|nullable|mongoid',
            'city' => 'string|nullable|mongoid',
            'company' => 'string|nullable',
            'positions' => 'filteredarray:'.implode(',', User::$_positions),
            'about' => 'string|nullable',
            'awards' => 'string|nullable',
            'portfolio' => 'string|nullable',
            'hasNoForeignPassport' => 'boolean|nullable',
            'weight' => 'int|max:250|nullable',
            'growth' => 'int|max:300|nullable',
            'eyes' => 'filteredarray:'.implode(',', User::$_eyes),
            'vocal' => 'filteredarray:'.implode(',', User::$_vocal),
            'dance' => 'filteredarray:'.implode(',', User::$_dance),
        ]);
        return $validator->fails() ? $validator->errors()->all() : true;
    }

    public static function isValidAvatar(Array $avatar = null)
    {
        if (!is_array($avatar)) {
            return false;
        }
        $validator = Validator::make($avatar, [
            'identity' => 'string|size:32|required',
            'type' => 'string|nullable',
            'size' => 'int|required',
            'url' => 'string|required',
        ]);
        return $validator->fails() ? $validator->errors()->all() : true;
    }

    /**
     * @param String|null $id
     * @return User|null
     */
    public static function get (String $id = null) {
        if (!$user = User::fetchOne(['id' => $id])) {
            throw new \App\Exceptions\EntityNotFoundException('User not found');
        }
        return User::fetchOne(['id' => $id]);
    }

    /**
     * @param User $user
     * @return User
     */
    public static function register(User $user) : User
    {

        $user->created_at = $user->updated_at = time();
        $user->is_active = false;
        $user->activation_token = uniqid();
        $user->password = password_hash($user->password, PASSWORD_BCRYPT);

        if (TRUE !== self::isValid($user)) {
            throw new \App\Exceptions\InvalidEntityException('User data validation errors: '.implode('; ', self::isValid($user)));
        }

        if(!self::isEmailAllowed($user->email, $user->id)) {
            throw new \App\Exceptions\User\EmailAlreadyExistsException;
        }
        if(!self::isNicknameAllowed($user->nickname, $user->id)) {
            throw new \App\Exceptions\User\NicknameAlreadyExistsException;
        }

        try {
            $user->save();
        } catch (\Exception $e) {
            throw new \App\Exceptions\CannotSaveEntityException('User cannot be saved');
        }

        self::sendRegistrationEmail($user->id);

        return $user;
    }

    /**
     * @param String $id
     * @param array $data
     * @return User
     * @throws \App\Exceptions\CannotSaveEntityException
     * @throws \App\Exceptions\EntityNotFoundException
     * @throws \App\Exceptions\InvalidEntityException
     * @throws \App\Exceptions\User\NicknameAlreadyExistsException
     */
    public static function update(String $id, Array $data = []) : User
    {
        if (!$user = User::fetchOne(['id' => $id])) {
            throw new \App\Exceptions\EntityNotFoundException('User not found');
        }

        $user->updated_at = time();
        $data['password'] = isset($data['password']) ? password_hash($data['password'], PASSWORD_BCRYPT) : $user->password;
        foreach (['_id','id','email','created_at','updated_at','activated_at','activation_token','is_active'] as $k) {
            if (isset($data[$k])) {
                unset($data[$k]);
            }
        }
        $user->populate($data);

        if (TRUE !== self::isValid($user)) {
            throw new \App\Exceptions\InvalidEntityException('User data is not valid');
        }

        if ($user->avatar && TRUE !== self::isValidAvatar($user->avatar)) {
            throw new \App\Exceptions\InvalidEntityException('Avatar data is not valid');
        }

        if(!self::isNicknameAllowed($user->nickname, $user->id)) {
            throw new \App\Exceptions\User\NicknameAlreadyExistsException;
        }

        try {
            $user->save();
        } catch (\Exception $e) {
            throw new \App\Exceptions\CannotSaveEntityException('User cannot be saved');
        }

        return $user;
    }

    /**
     * @param String $id
     * @return void
     * @throws \App\Exceptions\CannotSaveEntityException
     * @throws \App\Exceptions\EntityNotFoundException
     * @throws \App\Exceptions\InvalidEntityException
     * @throws \App\Exceptions\User\NicknameAlreadyExistsException
     */
    public static function delete(String $id) : void
    {

        if (!$user = User::fetchOne(['id' => $id])) {
            throw new \App\Exceptions\EntityNotFoundException('User not found');
        }

        try {
            $user->remove();
        } catch (\Exception $e) {
            throw new \App\Exceptions\CannotRemoveEntityException('User cannot be deleted');
        }
    }

    /**
     * @param String $id User id
     * @return array
     */
    public static function setAvatar(String $id) : array {
        $avatar = resolve('\Storage\Storage')->upload('avatar', \Storage\Storage::FILES)[0]->asArray();
        if (TRUE !== self::isValidAvatar($avatar)) {
            throw new \App\Exceptions\InvalidEntityException('Avatar data is not valid');
        }

        if (!$user = User::fetchOne(['id' => $id])) {
            throw new \App\Exceptions\EntityNotFoundException('User not found');
        }

        $user->avatar = $avatar;
        try {
            $user->save();
        } catch (\Exception $e) {
            throw new \App\Exceptions\CannotSaveEntityException('User cannot be saved');
        }

        return $avatar;
    }

    /**
     * @param String $id
     * @return bool
     * @throws \App\Exceptions\CannotRemoveEntityException
     * @throws \App\Exceptions\EntityNotFoundException
     * @throws \App\Exceptions\User\InvalidEntityException
     */
    public static function deleteAvatar(String $id) : bool {

        if (!$user = User::fetchOne(['id' => $id])) {
            throw new \App\Exceptions\EntityNotFoundException('User not found');
        }

        if (!$user->avatar) {
            return true;
        }

        if (!self::isValidAvatar($user->avatar)) {
            throw new \App\Exceptions\InvalidEntityException('Avatar data is not valid');
        }

        try {
            resolve('\Storage\Storage')->delete($user->avatar['identity']);
            $user->avatar = null;
            $user->save();
        } catch (\Exception $e) {
            throw new \App\Exceptions\CannotRemoveEntityException('Avatar cannot be deleted or user cannot be updated');
        }

        return true;

    }

    /**
     * @param String|null $email
     * @return User|null
     */
    public static function getUserByEmail (String $email = null) {
        return User::fetchOne(['email' => $email]);
    }

    /**
     * @param String|null $nickname
     * @return User|null
     */
    public static function getUserByNickname (String $nickname = null) {
        return User::fetchOne(['nickname' => $nickname]);
    }

    /**
     * @param String $email
     * @param Int|null $forUserId
     * @return bool
     */
    protected static function isEmailAllowed (String $email, Int $forUserId = null) : bool {
        $userDb = User::fetchOne(['email' => $email]);
        return is_null($userDb) ? true : ($userDb->id == $forUserId);
    }

    /**
     * @param String $nickname
     * @param Int|null $forUserId
     * @return bool
     */
    protected static function isNicknameAllowed (String $nickname, String $forUserId = null) : bool {
        $userDb = User::fetchOne(['nickname' => $nickname]);
        return is_null($userDb) ? true : ($userDb->id == $forUserId);
    }

    /**
     * @param String|null $nickname
     * @return bool
     */
    public static function isNicknameExists (String $nickname = null) : bool {
        return (bool) User::count(['nickname' => $nickname]);
    }

    /**
     * @param String $userId
     * @return bool
     */
    public static function sendRegistrationEmail (String $userId) : bool {
        return
            ($user = User::fetchOne(['id' => $userId]))
                &&
            mail(/*$user->email*/'zeitgeist1988@gmail.com', 'Now please activate your account' , env('APP_URL').'/user/activate/'.$user->activation_token)
        ;
    }

}