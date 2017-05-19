<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response as Response;
use App\Components\Api\JsonController;
use App\Mappers\UserMapper;
use App\Services\UserService;

class AuthController extends JsonController
{

    /**
     * @return Response
     */
    public function postLogin ()
    {
        if (FALSE === $result = UserService::login($this->getJsonParam('credentials.email'), $this->getJsonParam('credentials.password'), $this->getJsonParam('credentials.expire_at'))) {
            return $this->response([
                'authorized' => false,
            ]);
        }
        return $this->response(array_merge($result, [
            'authorized' => true,
        ]));

    }

}
