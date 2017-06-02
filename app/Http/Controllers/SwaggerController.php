<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response as Response;
use Illuminate\Http\Request as Request;
use Illuminate\Routing\Controller as BaseController;

class SwaggerController extends BaseController
{
    public function index()
    {
        //$swagger = \Swagger\scan('../app/Http');
        //$swagger = \Swagger\scan('../routes/web.php');
        $swagger = \Swagger\scan('..', ['exclude' => ['bootstrap','config','database','public','resources','storage','tests','vendor',]]);
        header('Content-Type: application/json');
        echo $swagger;
    }
}
