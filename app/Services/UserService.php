<?php

namespace App\Services;

use App\Components\Api\Exception;
use App\Exceptions\EntityNotFoundException;
use App\Exceptions\InvalidEntityException;
use \App\Models\User;
use App\Mappers\UserMapper;

use \Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;

class UserService extends AbstractService
{
    /**
     * @param \App\Models\AbstractModel $user
     * @return TRUE|array TRUE if valid, otherways array of errors
     */
    public static function isValid(\App\Models\AbstractModel $user)
    {
        $validator = Validator::make(UserMapper::execute($user, 'service')->toArray(), [
            'email' => 'email|max:255|required|string',
            'password' => 'string|size:60|required',
            'created_at' => 'int|required',
            'updated_at' => 'int|required',
            'activated_at' => 'int|nullable',
            'is_active' => 'boolean|required',
            'activation_token' => 'string|alpha_num|size:13|required',
            'access_tokens' => 'array',
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
            'hasForeignPassport' => 'boolean|nullable',
            'weight' => 'int|max:250|nullable',
            'growth' => 'int|max:300|nullable',
            'eyes' => 'filteredarray:'.implode(',', User::$_eyes),
            'vocal' => 'filteredarray:'.implode(',', User::$_vocal),
            'dance' => 'filteredarray:'.implode(',', User::$_dance),
        ]);
        return $validator->fails() ? $validator->errors()->all() : true;
    }

    /**
     * @param array|null $avatar
     * @return bool
     */
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
        $user->password = self::encryptPassword($user->password);

        if (TRUE !== self::isValid($user)) {
            throw new \App\Exceptions\InvalidEntityException('User data validation errors: '.implode('; ', self::isValid($user)));
        }

        if(!self::isEmailAllowed($user->email, $user->id)) {
            throw new \App\Exceptions\User\EmailAlreadyExistsException('Email already exists', 409);
        }
        if(!self::isNicknameAllowed($user->nickname, $user->id)) {
            throw new \App\Exceptions\User\NicknameAlreadyExistsException('Nickname already exists', 409);
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
        $data['password'] = isset($data['password']) ? self::encryptPassword($data['password']) : $user->password;
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

        if ($user->avatar_cropped && TRUE !== self::isValidAvatar($user->avatar_cropped)) {
            throw new \App\Exceptions\InvalidEntityException('Cropped avatar data is not valid');
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
     * @throws EntityNotFoundException
     * @throws InvalidEntityException
     * @throws \App\Exceptions\CannotSaveEntityException
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
     * @param String $id User id
     * @param Int $x
     * @param Int $y
     * @param Int $w
     * @param Int $h
     * @return array
     * @throws EntityNotFoundException
     * @throws Exception
     * @throws InvalidEntityException
     * @throws \App\Exceptions\CannotSaveEntityException
     */
    public static function cropAvatar(String $id, Int $x, Int $y, Int $w, Int $h) : array {

        if (!$user = User::fetchOne(['id' => $id])) {
            throw new \App\Exceptions\EntityNotFoundException('User not found');
        }

        if (TRUE !== self::isValidAvatar($user->avatar)) {
            throw new \App\Exceptions\InvalidEntityException('Avatar data is not valid');
        }

        resolve('\Storage\Storage')->delete($user->avatar_cropped['identity']);

        try {
            $avatarImagick = new \Imagick((config('services.storage.url') . $user->avatar['url']));
            $avatarImagick->cropImage($w, $h, $x, $y);
            $avatarImagick->setImageFormat('png');
            $avatarImagick->writeImage($tempnam = sys_get_temp_dir() . '/avatar_crop_' . str_replace(['.',' '], '_', microtime()) . '.png');
            $avatar_cropped = resolve('\Storage\Storage')->upload([$tempnam], \Storage\Storage::FILE)[0]->asArray();
            $avatar_cropped['width'] = $avatarImagick->getImageWidth();
            $avatar_cropped['height'] = $avatarImagick->getImageHeight();
            $user->avatar_cropped = $avatar_cropped;
        } catch (\Exception $e) {
            throw new \App\Components\Api\Exception('Cannot crop avatar', 500);
        }

        if(file_exists($tempnam)) {
            unlink($tempnam);
        }

        if (TRUE !== self::isValidAvatar($user->avatar_cropped)) {
            throw new \App\Exceptions\InvalidEntityException('Cropped avatar data is not valid');
        }
        try {
            $user->save();
        } catch (\Exception $e) {
            throw new \App\Exceptions\CannotSaveEntityException('User cannot be saved');
        }

        return $user->avatar_cropped;
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

        if (!$user->avatar && !$user->avatar_cropped) {
            return true;
        }

        if ($user->avatar && !self::isValidAvatar($user->avatar)) {
            throw new \App\Exceptions\InvalidEntityException('Avatar data is not valid');
        }

        if ($user->avatar_cropped && !self::isValidAvatar($user->avatar_cropped)) {
            throw new \App\Exceptions\InvalidEntityException('Cropped avatar data is not valid');
        }

        try {
            if($user->avatar) {
                resolve('\Storage\Storage')->delete($user->avatar['identity']);
                $user->avatar = null;
            }
            if($user->avatar_cropped) {
                resolve('\Storage\Storage')->delete($user->avatar_cropped['identity']);
                $user->avatar_cropped = null;
            }
            $user->save();
        } catch (\Exception $e) {
            throw new \App\Exceptions\CannotRemoveEntityException('Avatar/cropped avatar cannot be deleted or user cannot be updated');
        }

        return true;

    }

    public static function login (String $email, String $password, Int $accessTokenExpireAt = null) {

        if (!is_null($accessTokenExpireAt) && $accessTokenExpireAt < time()) {
            throw new InvalidEntityException('Expire time should be whether null or timestamp in future');
        }

        if (!$user = self::getUserByEmail($email)) {
            throw new EntityNotFoundException('User not found');
        }

        if (!$user->is_active) {
            return false;
        }

        if(!password_verify($password, $user->password)) {
            return false;
        }

        $accessTokens = $user->access_tokens;

        $token = [
            'access_token' => self::createAccessToken($email),
            'access_token_expire_at' => $accessTokenExpireAt,
            'access_token_last_used' => time(),
        ];

        $accessTokens[] = $token;

        $user->access_tokens = $accessTokens;

        if (TRUE !== self::isValid($user)) {
            throw new \App\Exceptions\InvalidEntityException('User data validation errors: '.implode('; ', self::isValid($user)));
        }

        try {
            $user->save();
        } catch (\Exception $e) {
            throw new \App\Exceptions\CannotSaveEntityException('User cannot be saved');
        }

        return $token;
    }

    public static function logout (String $accessToken) {

        if (!$user = self::getUserByAccessToken($accessToken)) {
            return true;
        }

        $accessTokens = $user->access_tokens;

        foreach ($accessTokens as $k => $v) {
            if ($v['access_token'] == $accessToken) {
                unset($accessTokens[$k]);
            }
        }

        $user->access_tokens = array_values($accessTokens);

        if (TRUE !== self::isValid($user)) {
            throw new \App\Exceptions\InvalidEntityException('User data validation errors: '.implode('; ', self::isValid($user)));
        }

        try {
            $user->save();
        } catch (\Exception $e) {
            throw new \App\Exceptions\CannotSaveEntityException('User cannot be saved');
        }

        return true;
    }

    protected static function createAccessToken (String $email) {

        return md5(env('APP_KEY').'|'.$email.'|'.time().'|'.microtime().rand(1, 100000));
    }

    /**
     * @param String|null $email
     * @return User|null
     */
    public static function getUserById (String $id = null) {
        return User::fetchOne(['id' => $id]);
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
     * @param String|null $access_token
     * @return User|null
     */
    public static function getUserByAccessToken (String $accessToken = null) {
        return User::fetchOne(['access_tokens' => ['$elemMatch' => ['access_token' => $accessToken]]]);
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

        $user = User::fetchOne(['id' => $userId]);

        Mail::to(/*$user->email*/'zeitgeist1988@gmail.com')
            ->send(new \App\Mail\UserRegistered($user));

        return true;

        return
            ($user = User::fetchOne(['id' => $userId]))
                &&
            mail(/*$user->email*/'zeitgeist1988@gmail.com', 'Now please activate your account' , env('APP_URL').'/user/activate/'.$user->activation_token)
        ;
    }

    /**
     * @param String $rawPassword
     * @return string
     */
    protected static function encryptPassword (String $rawPassword) : string {
        return password_hash($rawPassword, PASSWORD_BCRYPT);
    }

}