<?php

/**
 * @SWG\Definition(
 *     definition="Position",
 *     type="object",
 *
 * @SWG\Property(
 *     property="id",
 *     readOnly="true",
 *     type="string",
 *     example="591f2171ea6406591715f662"
 * ),
 * @SWG\Property(
 *     property="user_id",
 *     readOnly="true",
 *     type="string",
 *     example="591f2171ea6406591715f662"
 * ),
 * @SWG\Property(
 *     property="project_id",
 *     readOnly="true",
 *     type="string",
 *     example="591f2171ea6406591715f662"
 * ),
 * @SWG\Property(
 *     property="created_at",
 *     readOnly="true",
 *     type="integer",
 *     example="1495212401"
 * ),
 * @SWG\Property(
 *     property="updated_at",
 *     readOnly="true",
 *     type="integer",
 *     example="1495471353"
 * ),
 * @SWG\Property(
 *     property="title",
 *     type="string",
 *     example="Very clever person"
 * ),
 * @SWG\Property(
 *     property="position",
 *     type="string|required",
 *     example="director"
 * ),
 * @SWG\Property(
 *     property="position_custom",
 *     type="string",
 *     example="Very strange position"
 * ),
 * @SWG\Property(
 *     property="requirements",
 *     type="string|required",
 *     example="Requirements for this position"
 * ),
 * @SWG\Property(
 *     property="sex",
 *     type="string|null",
 *     example="m",
 *     example="w"
 * ),
 * @SWG\Property(
 *     property="work_experience",
 *     type="integer|null",
 *     example="3"
 * ),
 * @SWG\Property(
 *     property="is_paid",
 *     type="boolean|required",
 *     example="true"
 * ),
 * @SWG\Property(
 *     property="tax_type",
 *     type="string|null",
 *     example="fixed_price",
 *     example="time_and_material"
 * ),
 * @SWG\Property(
 *     property="competitors (readOnly)",
 *     type="array",
 *     @SWG\Items(type="string"),
 *     example="[591f2171ea6406591715f662,591f2171ea6406591715f662]"
 * ),
 * @SWG\Property(
 *     property="amount",
 *     type="integer",
 *     example="3"
 * ),
 * @SWG\Property(
 *     property="applied",
 *     type="integer",
 *     example="2"
 * ),
 * @SWG\Property(
 *     property="published",
 *     type="boolean"
 * ),
 * @SWG\Property(
 *     property="completed",
 *     type="boolean"
 * )
 * )
 */
