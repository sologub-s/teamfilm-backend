<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response as Response;
use Illuminate\Http\Request as Request;
use Illuminate\Routing\Controller as BaseController;

/**
 * @SWG\Swagger(
 *     schemes={"http","https"},
 *     host="teamfilm.dev",
 *     basePath="/api/v1",
 *     @SWG\Info(
 *         version="1.0.0",
 *         title="TeamFilm API v1",
 *         description="Api description...",
 *         termsOfService="",
 *         @SWG\Contact(
 *             email="zeitgeist@ukr.net"
 *         ),
 *         @SWG\License(
 *             name="Private License",
 *             url="URL to the license"
 *         )
 *     ),
 *     @SWG\ExternalDocumentation(
 *         description="Find out more about my website",
 *         url="http..."
 *     )
 * )
 */

class SwaggerController extends BaseController
{
    public function index()
    {
        $swagger = \Swagger\scan('../app/Http');
        header('Content-Type: application/json');
        echo $swagger;
    }
}
