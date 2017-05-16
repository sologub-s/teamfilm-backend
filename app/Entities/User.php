<?php

namespace App\Entities;

//use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Doctrine\ORM\Mapping as ORM;
use Validator;

/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 */
class User extends AbstractEntity
{

    /**
     * $id
     */
    use Traits\PrimaryKey;

    /**
     * $createdAt and $updatedAt
     */
    use TimestampableEntity;

    /**
     * @ORM\Column(type="string",unique=true)
     */
    protected $email;

    /**
     * @ORM\Column(type="string")
     */
    protected $name;

    /**
     * @ORM\Column(type="string")
     */
    protected $surname;

    /**
     * @ORM\Column(type="string")
     */
    protected $nickname;

    /**
     * @ORM\Column(type="string",length=20,nullable=true,unique=true)
     */
    protected $cellphone;

    /**
     * @ORM\Column(type="string",length=1,nullable=true)
     */
    protected $sex;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime",nullable=true)
     */
    protected $birthday;

    /**
     * @return Array
     */
    public function getFields () : Array
    {
        return ['email','name','surname','nickname','cellphone','sex','birthday'];
    }


    public function isValid () : bool {
        return !Validator::make($this->toArray(), [
            'email' => 'email|max:255|required|string|unique:users,email'.(is_null($this->getId()) ? ',id' : ','.$this->getId()),
            'name' => 'string|max:255|required|alpha_dash',
            'surname' => 'string|max:255|required|alpha_dash',
            'nickname' => 'string|max:255|required|alpha_dash|unique:users,nickname'.(is_null($this->getId()) ? ',id' : ','.$this->getId()),
            'cellphone' => 'string|max:20|nullable|phone:AUTO',
            'sex' => 'string|size:1|nullable|in:m,w',
            'birthday' => 'datetime|nullable'
        ])->fails();
    }

    /**
     * @return string|null
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param String $email
     */
    public function setEmail(String $email)
    {
        $this->email = $email;
    }

    /**
     * @return String|null
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param String $name
     */
    public function setName(String $name)
    {
        $this->name = $name;
    }

    /**
     * @return String|null
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * @param String $surname
     */
    public function setSurname(String $surname) {
        $this->surname = $surname;
    }

    /**
     * @return String|null
     */
    public function getNickname()
    {
        return $this->nickname;
    }

    /**
     * @param String $nickname
     */
    public function setNickname(String $nickname)
    {
        $this->nickname = $nickname;
    }

    /**
     * @return String|null
     */
    public function getCellphone()
    {
        return $this->cellphone;
    }

    /**
     * @param String|null $cellphone
     */
    public function setCellphone(String $cellphone = null)
    {
        $this->cellphone = $cellphone;
    }

    /**
     * @return string|null
     */
    public function getSex()
    {
        return $this->sex;
    }

    /**
     * @param string|null $sex
     */
    public function setSex(String $sex = null)
    {
        $this->sex = $sex;
    }

    /**
     * @return Int|null
     */
    public function getBirthday()
    {
        return is_null($this->birthday) ? null : $this->birthday->getTimestamp();
    }

    /**
     * @param Integer|null $birthday
     */
    public function setBirthday(Int $birthday = null)
    {
        $this->birthday = is_null($birthday) ? $birthday : new \DateTime('@' . (string) $birthday);
    }
}