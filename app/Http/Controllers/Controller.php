<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use Authorizesequests, DispatchesJobs, ValidatesRequests;

    public function index ()
    {
        /*
        // Example of how to throw HTTP errors
        //throw new \App\Components\Api\Exception(null, 500);
        // Example of how to throw regular errors
        //throw new \Exception('Laja');

        // Eloquent example
        try {
            $user = \App\Models\User::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new \App\Components\Api\Exception("User with id '".$id."' not found", 404);
        }

        if (is_null($user = $this->getOm()->find('App\Entities\User', $id))) {
            throw new \App\Components\Api\Exception("User with id '".$id."' not found", 404);
        }

        return $this->response([
            'user' => $user->toArray(),
        ]);
        */
    }
}
