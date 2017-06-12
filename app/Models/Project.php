<?php

namespace App\Models;

/**
 * Class Project
 *
 * @collection Project
 *
 * @primary id
 *
 * @property string     $id
 * @property string     $user_id
 * @property string     $title
 * @property string     $description
 * @property int        $created_at
 * @property int        $updated_at
 * @property string     $type
 * @property array      $genres
 * @property string     $genres_custom
 * @property int        $start_date
 * @property int        $deadline_date
 * @property int        $duration
 * @property array      $logo
 * @property string     $country
 * @property string     $city
 * @property string     $place
 * @property string     $status
 *
 * @method static Project[]    fetchAll($cond = null, $sort = null, int $count = null, int $offset = null)
 * @method static Project|null fetchOne($cond = null, $sort = null)
 * @method static Project      fetchObject($cond = null, $sort = null)
 * @method static void         remove($cond = null)
 *
 * @method void save()
 *
 */
class Project extends AbstractModel
{

    public static $_types = ['movie','series','ads',];

    public static $_genres = ['horror','porn','sci-fi porn',];

    public static $_statuses = ['on_hold', 'in_progress','done',];

}