<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use Illuminate\Support\Facades\Mail;

class UserTest extends TestCase
{

    protected static function sanitizeDb()
    {

        if(false === stristr(env('MONGODB_DATABASE'), 'testing')) {
            throw new \Exception("Are you sure you are going to naebnut' '".env('MONGODB_DATABASE')."' ('testing' keyword should be present in database name) ?..");
        }

        try {
            $manager = new \MongoDB\Driver\Manager('mongodb://'.env('MONGODB_SERVER', 'localhost').':'
                .env('MONGODB_PORT', '27017').')');
            $cursor = $manager->executeCommand(env('MONGODB_DATABASE'), new \MongoDB\Driver\Command(['dropDatabase' => 1]));
        } catch (\Exception $e) {
            throw new \Exception("MongoDB connecting/commanding error");
        }
        if (!($cursor->toArray()[0]->ok == 1)) {
            throw new \Exception("Cannot naebnut' '".env('MONGODB_DATABASE')."'");
        }

        echo "\nNaebnuli '".env('MONGODB_DATABASE')."'";
    }

    public static function setUpBeforeClass ()
    {
        echo "\nEnvironment is " . env('APP_ENV');
        echo "\nSET UP";
        parent::setUpBeforeClass();
        self::sanitizeDb();
    }

    public static function tearDownAfterClass()
    {
        echo "\nTEAR DOWN";
        parent::tearDownAfterClass();
        //self::sanitizeDb();
    }

    /**
     * User creation
     *
     * @return void
     */
    public function testUserCreation()
    {

        $userJson = file_get_contents(dirname(__FILE__).'/UserTest/user.json');

        $beforeTimestamp = time();
        $response = $this->json('POST', 'v1/user', (array) json_decode($userJson, true));
        $afterTimestamp = time();
        $userArrayMapped = (array) json_decode($userJson, true);
        unset($userArrayMapped['user']['password']);
        $response
            ->assertStatus(200)
            ->assertJson($userArrayMapped)
            ->assertJsonFragment([
                'is_active' => false,
            ])
        ;
        $data = json_decode($response->getContent(), true)['user'];

        $this->assertArrayHasKey('id', $data);
        $this->assertArrayHasKey('avatar', $data);
        $this->assertNull($data['avatar']);
        $this->assertArrayHasKey('avatar_cropped', $data);
        $this->assertNull($data['avatar_cropped']);
        try {
            new \MongoDB\BSON\ObjectID($data['id']);
        } catch (\Exception $e) {
            $this->fail($e->getMessage());
        }

        foreach (['created_at','updated_at'] as $key) {
            $this->assertLessThanOrEqual($afterTimestamp, $data[$key]);
            $this->assertGreaterThanOrEqual($beforeTimestamp, $data[$key]);
        }

        $this->assertFalse($data['is_active']);

        if (strlen($data['activation_token']) !== 13) {
            $this->fail('activation_token should be a 13 characters string !');
        }

        return $data['id'];

    }

    /**
     * @depends testUserCreation
     */
    public function testGetUserById($userId) {
        $response = $this->json('GET', 'v1/user/'.$userId, ['user' => []]);
        $response
            ->assertStatus(200)
            ->assertJsonFragment([
                'id' => $userId,
            ])
        ;
    }

    /**
     * Trying brutally activate User should be impossible
     * @depends testUserCreation
     * @return void
     */
    public function testUserNotActivatingBrutally($userId)
    {
        $response = $this->json('PATCH', 'v1/user/'.$userId, ['user' => [
            'is_active' => true,
        ]]);
        $response
            ->assertStatus(200)
            ->assertJsonFragment([
                'is_active' => false,
            ])
        ;
    }

}
