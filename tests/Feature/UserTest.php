<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testUserCreation()
    {
        //dd(env('APP_ENV'));
        $response = $this->json('POST', 'v1/user',
            (array) json_decode('{
                "user": {
                    "email": "zeitgeist@ukr.net",
                        "password": "12345",
                        "name": "Serhii",
                        "surname": "Solohub",
                        "nickname": "ZeitGeist",
                        "cellphone": "+380938923508",
                        "sex": "m",
                        "birthday": "576842464",
                        "country": "583f35399bb2f9300fd1effe",
                        "city": "583f355a9bb2f9300fd1efff",
                        "company": "TeamFilm",
                        "positions": ["ceo"],
                        "about": "I, me and myself",
                        "awards": "Golden Axe",
                        "portfolio": "A lot of work has been done",
                        "hasForeignPassport": false,
                        "weight": "140",
                        "growth": "182",
                        "eyes": ["brown"],
                        "vocal": ["bass","soprano"],
                        "dance": ["hip-hop"]
                }
            }')
        );
        dd($response->getContent());
        $response
            ->assertStatus(200);
    }
}
