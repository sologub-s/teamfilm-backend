<?php

namespace App\Models;

/**
 * Class Position
 *
 * @collection Position
 *
 * @primary id
 *
 * @property string     $id
 * @property string     $user_id
 * @property string     $project_id
 * @property string     $title
 * @property string     $position
 * @property string     $position_custom
 * @property string     $requirements
 * @property string     $sex
 * @property int        $work_experience
 * @property boolean    $is_paid
 * @property string     $tax_type
 * @property array      $competitors
 * @property int        $amount
 * @property int        $applied
 * @property boolean    $published
 * @property boolean    $completed
 *
 * @method static Project[]    fetchAll($cond = null, $sort = null, int $count = null, int $offset = null)
 * @method static Project|null fetchOne($cond = null, $sort = null)
 * @method static Project      fetchObject($cond = null, $sort = null)
 * @method static void         remove($cond = null)
 *
 * @method void save()
 *
 */
class Position extends AbstractModel
{

    public static $_positions = ['porn_actress','operator','director',];

    public static $_tax_types = ['fixed_price','time_and_materials',];

}