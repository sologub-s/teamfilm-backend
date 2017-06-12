<?php

/**
 * @SWG\Definition(
 *     definition="Project",
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
 *     property="title",
 *     type="string|required",
 *     example="The Pet Project"
 * ),
 * @SWG\Property(
 *     property="description",
 *     type="string|required",
 *     example="This is very interesting project"
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
 *     property="type",
 *     type="string",
 *     @SWG\Items(type="string"),
 *     example="'movie','series','ads'"
 * ),
 * @SWG\Property(
 *     property="genres",
 *     type="array",
 *     @SWG\Items(type="string"),
 *     example="[horror, porno, sci-fi porno]"
 * ),
 * @SWG\Property(
 *     property="genres_custom",
 *     type="string",
 *     example="new interesting genre name"
 * ),
 * @SWG\Property(
 *     property="start_date",
 *     type="integer",
 *     example="1495212401"
 * ),
 * @SWG\Property(
 *     property="deadline_date",
 *     type="integer",
 *     example="1495212401"
 * ),
 * @SWG\Property(
 *     property="duration",
 *     type="integer",
 *     example="7"
 * ),
 * @SWG\Property(
 *     property="logo (null)",
 *     ref="#/definitions/Logo"
 * ),
 * @SWG\Property(
 *     property="country",
 *     type="string|null",
 *     example="583f35399bb2f9300fd1effe"
 * ),
 * @SWG\Property(
 *     property="city",
 *     type="string|null",
 *     example="583f355a9bb2f9300fd1efff"
 * ),
 * @SWG\Property(
 *     property="place",
 *     type="string",
 *     example="34.75,23.12"
 * ),
 * @SWG\Property(
 *     property="status",
 *     type="array",
 *     @SWG\Items(type="string"),
 *     example="on_hold, in_progress, done"
 * )
 * )
 */

/**
 * @SWG\Definition(
 *   definition="Logo",
 *   type="object",
 *
 *   @SWG\Property(
 *     property="identity",
 *     type="string",
 *     example="95d4137d95f6c70eaa458f4672ba6af3"
 *   ),
 *   @SWG\Property(
 *     property="name",
 *     type="string",
 *     example="T4QpvGLMh8U.jpg"
 *   ),
 *   @SWG\Property(
 *     property="type",
 *     type="string",
 *     example="image/png"
 *   ),
 *   @SWG\Property(
 *     property="size",
 *     type="string",
 *     example="155663"
 *   ),
 *   @SWG\Property(
 *     property="url",
 *     type="string",
 *     example="/storage/9/5/d/4/95d4137d95f6c70eaa458f4672ba6af3.jpg"
 *   ),
 *   @SWG\Property(
 *     property="width",
 *     type="integer",
 *     example="684"
 *   ),
 *   @SWG\Property(
 *     property="height",
 *     type="integer",
 *     example="1024"
 *   )
 *
 * )
 */