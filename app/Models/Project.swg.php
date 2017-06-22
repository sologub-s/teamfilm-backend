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
 *     example="new interesting genre name"
 * ),
 *
 *
 *
 *

 * @SWG\Property(
 *     property="activated_at",
 *     readOnly="true",
 *     type="integer|null",
 *     example="1495471353"
 * ),
 * @SWG\Property(
 *     property="is_active",
 *     type="boolean",
 *     readOnly="true",
 *     example="true"
 * ),
 * @SWG\Property(
 *     property="activation_token",
 *     type="string",
 *     readOnly="true",
 *     example="591f21713be4e"
 * ),
 * @SWG\Property(
 *     property="name",
 *     type="string|required",
 *     example="Serhii"
 * ),
 * @SWG\Property(
 *     property="surname",
 *     type="string|required",
 *     example="Solohub"
 * ),
 * @SWG\Property(
 *     property="nickname",
 *     type="string|null",
 *     example="ZeitGeist"
 * ),
 * @SWG\Property(
 *     property="cellphone",
 *     type="string|null",
 *     example="+380938923508"
 * ),
 * @SWG\Property(
 *     property="sex",
 *     type="string|null",
 *     example="m",
 *     example="w"
 * ),
 * @SWG\Property(
 *     property="birthday",
 *     type="integer|null",
 *     example="576842464"
 * ),

 * @SWG\Property(
 *     property="company",
 *     type="string|null",
 *     example="TeamFilm"
 * ),
 * @SWG\Property(
 *     property="positions",
 *     type="array",
 *     @SWG\Items(type="string"),
 *     example="[ceo, hr, artist, singer, dancer, director, cto]"
 * ),
 * @SWG\Property(
 *     property="about",
 *     type="string|null",
 *     example="I, me and myself"
 * ),
 * @SWG\Property(
 *     property="awards",
 *     type="string|null",
 *     example="Golden Axe"
 * ),
 * @SWG\Property(
 *     property="portfolio",
 *     type="string|null",
 *     example="A lot of work has been done"
 * ),
 * @SWG\Property(
 *     property="hasForeignPassport",
 *     type="boolean|null",
 *     example="false"
 * ),
 * @SWG\Property(
 *     property="weight",
 *     type="integer|null",
 *     example="140"
 * ),
 * @SWG\Property(
 *     property="growth",
 *     type="integer|null",
 *     example="182"
 * ),
 * @SWG\Property(
 *     property="eyes",
 *     type="array",
 *     @SWG\Items(type="string"),
 *     example="[red, green, blue, brown, grey]"
 * ),
 * @SWG\Property(
 *     property="vocal",
 *     type="array",
 *     @SWG\Items(type="string"),
 *     example="[alt, soprano, bass]"
 * ),
 * @SWG\Property(
 *     property="dance",
 *     type="array",
 *     @SWG\Items(type="string"),
 *     example="[hip-hop, strip, balley, disco, rumba, chachacha]"
 * ),

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