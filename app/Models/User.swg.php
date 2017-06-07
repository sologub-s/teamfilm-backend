<?php

/**
 * @SWG\Definition(
 *     definition="User",
 *     type="object",
 *
 * @SWG\Property(
 *     property="id",
 *     readOnly="true",
 *     type="string",
 *     example="591f2171ea6406591715f662"
 * ),
 * @SWG\Property(
 *     property="email",
 *     type="string|required",
 *     example="zeitgeist@teamfilm.dev"
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
 * @SWG\Property(
 *     property="avatar (null|readOnly)",
 *     ref="#/definitions/Avatar"
 * ),
 * @SWG\Property(
 *     property="avatar_cropped (null|readOnly)",
 *     ref="#/definitions/Avatar"
 * )
 * )
 */

/**
 * @SWG\Definition(
 *   definition="Avatar",
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

/**
 * @SWG\Definition(
 *   definition="Crop",
 *   type="object",
 *
 *   @SWG\Property(
 *     property="x",
 *     type="integer|required",
 *     example="30"
 *   ),
 *   @SWG\Property(
 *     property="y",
 *     type="integer|required",
 *     example="50"
 *   ),
 *   @SWG\Property(
 *     property="w",
 *     type="integer|required",
 *     example="200"
 *   ),
 *   @SWG\Property(
 *     property="h",
 *     type="integer|required",
 *     example="300"
 *   )
 * )
 */

/**
 * @SWG\Definition(
 *   definition="LogIn",
 *   type="object",
 *
 *   @SWG\Property(
 *     property="email",
 *     type="string|required",
 *     example="zeitgeist@ukr.net"
 *   ),
 *   @SWG\Property(
 *     property="password",
 *     type="string|required",
 *     example="12345"
 *   ),
 *   @SWG\Property(
 *     property="access_token_expire_at",
 *     type="string|required",
 *     example="9999999999"
 *   )
 * )
 */

/**
 * @SWG\Definition(
 *   definition="LogOut",
 *   type="object",
 *
 *   @SWG\Property(
 *     property="access_token",
 *     type="string|required",
 *     example="0d8030c303eb296ac268555bb4011c53"
 *   )
 * )
 */