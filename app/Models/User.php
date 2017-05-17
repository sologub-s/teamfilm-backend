<?php

namespace App\Models;

/**
 * Class User
 *
 * @collection User
 *
 * @primary id
 *
 * @property string     $id
 * @property string     $email
 * @property string     $password
 * @property int        $created_at
 * @property int        $updated_at
 * @property int        $activated_at
 * @property boolean    $is_active
 * @property string     $activation_token
 * @property string     $name
 * @property string     $surname
 * @property string     $nickname
 * @property string     $cellphone
 * @property string     $sex
 * @property int        $birthday
 * @property string     $country
 * @property string     $city
 * @property string     $company
 * @property array      $positions
 * @property string     $about
 * @property string     $awards
 * @property string     $portfolio
 * @property boolean    $hasForeignPassport
 * @property int        $weight
 * @property int        $growth
 * @property array      $eyes
 * @property array      $vocal
 * @property array      $dance
 * @property array      $avatar
 *
 * @method static User[]    fetchAll($cond = null, $sort = null, int $count = null, int $offset = null)
 * @method static User|null fetchOne($cond = null, $sort = null)
 * @method static User      fetchObject($cond = null, $sort = null)
 * @method static void      remove($cond = null)
 *
 * @method void save()
 */
class User extends AbstractModel
{

    public static $_positions = ['ceo','hr','artist','singer','dancer',];

    public static $_eyes = ['red','green','blue','brown','grey',];

    public static $_vocal = ['alt','soprano','bass',];

    public static $_dance = ['hip-hop','strip','balley','disco','rumba','chachacha'];

}