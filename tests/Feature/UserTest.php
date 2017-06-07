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

    /**
     * Real file upload
     *
     * @param String $url
     * @param String $path
     * @return array
     */
    protected function uploadFile(String $url, String $path, String $access_token) {

        // initialise the curl request
        $request = curl_init($url);

        // send a file
        curl_setopt($request, CURLOPT_POST, true);
        curl_setopt($request, CURLOPT_HEADER, true);
        curl_setopt($request, CURLOPT_HTTPHEADER, ['X-Auth: '.$access_token,]);
        curl_setopt($request, CURLOPT_POSTFIELDS, [
            'avatar[]' => new \CURLFile($path),
        ]);

        // output the response
        curl_setopt($request, CURLOPT_RETURNTRANSFER, true);
        $return = [
            'content' => explode("\r\n\r\n", curl_exec($request))[2],
            'code' => curl_getinfo($request, CURLINFO_HTTP_CODE),
        ];
        // close the session
        curl_close($request);

        return $return;
    }

    public function is_url_exist($url){
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if($code == 200){
            $status = true;
        }else{
            $status = false;
        }
        curl_close($ch);
        return $status;
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
     * @param $userId
     * @return mixed
     */
    protected function getUser($userId, $access_token) {
        $response = $this->json('GET', 'v1/user/'.$userId, [], ['X-Auth'=>$access_token]);
        return json_decode($response->getContent(), true)['user'];
    }

    /**
     * User creation
     *
     * @return void
     */
    public function testUserCreation()
    {

        Mail::fake();

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

        Mail::assertSent(\App\Mail\UserRegistered::class, function ($mail) use ($data) {
            return $mail->hasTo('zeitgeist1988@gmail.com') && false !== stristr($mail->render(), env('APP_URL').'/user/activate/'.$data['activation_token']);
        });

        return $data;

    }

    /**
     * @param $userId
     * @depends testUserCreation
     */
    public function testUserActivation($user) {
        $beforeTimestamp = time();
        $response = $this->json('POST', 'v1/user/activate/'.$user['activation_token']);
        $afterTimestamp = time();
        $response
            ->assertStatus(200)
            ->assertJsonFragment([
                'id' => $user['id'],
                'is_active' => true,
            ])
        ;
        $data = json_decode($response->getContent(), true)['user'];
        $this->assertGreaterThanOrEqual($beforeTimestamp, $data['activated_at']);
        $this->assertLessThanOrEqual($afterTimestamp, $data['activated_at']);
    }

    /**
     * @depends testUserCreation
     */
    public function testUserLogin($user)
    {
        $userJson = file_get_contents(dirname(__FILE__).'/UserTest/user.json');
        $userJsonDecoded = json_decode($userJson, true)['user'];
        $response = $this->json('POST', 'v1/user/login', ['login' => [
            'email' => $userJsonDecoded['email'],
            'password' => $userJsonDecoded['password'],
            'access_token_expire_at' => 9999999999,
        ],]);
        $response
            ->assertStatus(200)
            ->assertJsonFragment([
                'access_token_expire_at' => 9999999999,
            ])
        ;
        $responseDecoded = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('login', $responseDecoded);
        $this->assertArrayHasKey('access_token', $responseDecoded['login']);
        $this->assertArrayHasKey('access_token_last_used', $responseDecoded['login']);

        return ['user' => $user, 'access_token' => $responseDecoded['login']['access_token']];
    }

    /**
     * @depends testUserLogin
     */
    public function testGetUserById($creds) {
        $response = $this->json('GET', 'v1/user/'.$creds['user']['id'], [], ['X-Auth'=>$creds['access_token']]);
        $response
            ->assertStatus(200)
            ->assertJsonFragment([
                'id' => $creds['user']['id'],
            ])
        ;
    }

    /**
     * @param $userId
     * @depends testUserLogin
     * @return void
     */
    public function testGetUserByNotId($creds) {

        $responseByEmail = $this->json('GET', 'v1/user/by/email/'.$creds['user']['email'],[],['X-Auth'=>$creds['access_token']]);
        $responseByEmail
            ->assertStatus(200)
            ->assertJsonFragment([
                'id' => $creds['user']['id'],
                'email' => $creds['user']['email'],
            ])
        ;

        $responseByNonExistingEmail = $this->json('GET', 'v1/user/by/email/'.'nonexistingemail@example.com',[],['X-Auth'=>$creds['access_token']]);
        $responseByNonExistingEmail->assertStatus(404);

        $responseByNickname = $this->json('GET', 'v1/user/by/nickname/'.$creds['user']['nickname'],[],['X-Auth'=>$creds['access_token']]);
        $responseByNickname
            ->assertStatus(200)
            ->assertJsonFragment([
                'id' => $creds['user']['id'],
                'nickname' => $creds['user']['nickname'],
            ])
        ;

        $responseByNonExistingNickname = $this->json('GET', 'v1/user/by/nickname/'.'Non Existing-Nick_Name111',[],['X-Auth'=>$creds['access_token']]);
        $responseByNonExistingNickname->assertStatus(404);

        $responseByActivationToken = $this->json('GET', 'v1/user/by/activation_token/'.$creds['user']['activation_token'],[],['X-Auth'=>$creds['access_token']]);
        $responseByActivationToken
            ->assertStatus(200)
            ->assertJsonFragment([
                'id' => $creds['user']['id'],
                'activation_token' => $creds['user']['activation_token'],
            ])
        ;

        $responseByNonExistingActivationToken = $this->json('GET', 'v1/user/by/activation_token/'.uniqid(),[],['X-Auth'=>$creds['access_token']]);
        $responseByNonExistingActivationToken->assertStatus(404);
    }

    /**
     * @param $userId
     * @depends testUserLogin
     */
    public function testUserAvatar($creds) {
        $file = dirname(__FILE__).'/UserTest/terminator.jpg';
        $result = $this->uploadFile(env('APP_URL').'/v1/user/'.$creds['user']['id'].'/avatar'.'?testing', $file, $creds['access_token']);
        $this->assertEquals($result['code'], 200);
        $avatarJson = json_decode($result['content'], true);
        $this->assertArrayHasKey('avatar', $avatarJson);

        $avatarResponse = $this->json('GET', 'v1/user/'.$creds['user']['id'].'/avatar',[],['X-Auth'=>$creds['access_token']])->assertStatus(200);
        $avatarContent = $avatarResponse->getContent();
        $avatar = json_decode($avatarContent, true);
        $this->assertTrue(is_array($avatar['avatar']));
        $this->assertArrayHasKey('identity', $avatar['avatar']);
        $this->assertArrayHasKey('name', $avatar['avatar']);
        $this->assertArrayHasKey('url', $avatar['avatar']);
        $this->assertEquals($avatarJson['avatar']['identity'], $avatar['avatar']['identity']);
        $this->assertEquals($avatarJson['avatar']['name'], $avatar['avatar']['name']);
        $this->assertEquals($avatarJson['avatar']['url'], $avatar['avatar']['url']);

        $localFileImagick = new \Imagick($file);
        try {
            $avatarImagick = new \Imagick((config('services.storage.url') . $avatar['avatar']['url']));
        } catch (\Exception $e) {
            $this->fail($e->getMessage());
        }
        $this->assertEquals($localFileImagick->getImageWidth(), $avatarImagick->getImageWidth());
        $this->assertEquals($localFileImagick->getImageHeight(), $avatarImagick->getImageHeight());

        $cropParams = [
            'x' => 30,
            'y' => 50,
            'w' => 400,
            'h' => 300,
        ];
        $cropResponse = $this->json('POST', 'v1/user/'.$creds['user']['id'].'/avatar/crop', ['crop' => $cropParams,],['X-Auth'=>$creds['access_token']]);
        $cropResponse->assertStatus(200);
        $cropContent = $cropResponse->getContent();
        $crop = json_decode($cropContent, true);
        $this->assertArrayHasKey('identity', $crop['avatar']);
        $this->assertArrayHasKey('name', $crop['avatar']);
        $this->assertArrayHasKey('url', $crop['avatar']);
        $this->assertArrayHasKey('width', $crop['avatar']);
        $this->assertArrayHasKey('height', $crop['avatar']);
        try {
            $cropImagick = new \Imagick((config('services.storage.url') . $crop['avatar']['url']));
        } catch (\Exception $e) {
            $this->fail($e->getMessage());
        }
        $this->assertEquals($cropImagick->getImageWidth(), $cropParams['w']);
        $this->assertEquals($cropImagick->getImageHeight(), $cropParams['h']);

        $user = $this->getUser($creds['user']['id'], $creds['access_token']);
        $this->assertTrue(is_array($user['avatar_cropped']));
        $this->assertEquals($user['avatar_cropped']['identity'], $crop['avatar']['identity']);

        $this->assertTrue($this->is_url_exist((config('services.storage.url') . $avatar['avatar']['url'])));
        $this->assertTrue($this->is_url_exist((config('services.storage.url') . $crop['avatar']['url'])));

        $this->json('DELETE', 'v1/user/'.$creds['user']['id'].'/avatar',[],['X-Auth'=>$creds['access_token']])->assertStatus(200);
        $user = $this->getUser($creds['user']['id'], $creds['access_token']);
        $this->assertNull($user['avatar']);
        $this->assertNull($user['avatar_cropped']);
        $this->assertFalse($this->is_url_exist((config('services.storage.url') . $avatar['avatar']['url'])));
        $this->assertFalse($this->is_url_exist((config('services.storage.url') . $crop['avatar']['url'])));
    }

    public function testUserRestrictions () {

        self::sanitizeDb();

        Mail::fake();

        $userJsonDecoded1 = (array) json_decode(file_get_contents(dirname(__FILE__).'/UserTest/user.json'), true);
        $userJsonDecoded2 = array_replace_recursive($userJsonDecoded1, ['user' => [
            'email' => 'bob_marlie@teamfilm.dev',
            'nickname' => 'Bob_Marlie',
            'name' => 'Bob',
            'surname' => 'Marlie',
        ]]);

        $response = $this->json('POST', 'v1/user', $userJsonDecoded1);
        $response->assertStatus(200);
        $userData1 = json_decode($response->getContent(), true)['user'];
        $response = $this->json('POST', 'v1/user/activate/'.$userData1['activation_token']);
        $response->assertStatus(200)->assertJsonFragment(['is_active' => true,]);
        $response = $this->json('POST', 'v1/user/login', ['login' => [
            'email' => $userJsonDecoded1['user']['email'],
            'password' => $userJsonDecoded1['user']['password'],
            'access_token_expire_at' => 9999999999,
        ],]);
        $response->assertStatus(200);
        $accessToken1 = json_decode($response->getContent(), true)['login']['access_token'];

        $response = $this->json('POST', 'v1/user', $userJsonDecoded2);
        $response->assertStatus(200);
        $userData2 = json_decode($response->getContent(), true)['user'];
        $response = $this->json('POST', 'v1/user/activate/'.$userData2['activation_token']);
        $response->assertStatus(200)->assertJsonFragment(['is_active' => true,]);
        $response = $this->json('POST', 'v1/user/login', ['login' => [
            'email' => $userJsonDecoded2['user']['email'],
            'password' => $userJsonDecoded2['user']['password'],
            'access_token_expire_at' => 9999999999,
        ],]);
        $response->assertStatus(200);
        $accessToken2 = json_decode($response->getContent(), true)['login']['access_token'];

        $response = $this->json('GET', 'v1/user/'.$userData1['id'], [], ['X-Auth'=>$accessToken1]);
        $response
            ->assertStatus(200)
            ->assertJsonFragment([
                'id' => $userData1['id'],
                'email' => $userData1['email'],
                'nickname' => $userData1['nickname'],
                'cellphone' => $userData1['cellphone'],
            ])
        ;

        $response = $this->json('GET', 'v1/user/'.$userData1['id'], [], ['X-Auth'=>$accessToken2]);
        $response
            ->assertStatus(200)
            ->assertJsonFragment([
                'id' => $userData1['id'],
                'nickname' => $userData1['nickname'],
            ])
        ;
        $responseDecoded = json_decode($response->getContent(), true)['user'];
        foreach (['email','cellphone','created_at','updated_at','activated_at','is_active','activation_token'] as $key) {
            $this->assertArrayNotHasKey($key, $responseDecoded);
        }

        $response = $this->json('patch', 'v1/user/'.$userData1['id'], ['user'=>['nickname'=>'Change Me']], ['X-Auth'=>$accessToken2]);
        $response->assertStatus(403);

        $response = $this->json('delete', 'v1/user/'.$userData1['id'], [], ['X-Auth'=>$accessToken2]);
        $response->assertStatus(403);

        $response = $this->json('post', 'v1/user/'.$userData1['id'].'/avatar', [], ['X-Auth'=>$accessToken2]);
        $response->assertStatus(403);

        $response = $this->json('delete', 'v1/user/'.$userData1['id'].'/avatar', [], ['X-Auth'=>$accessToken2]);
        $response->assertStatus(403);

        $response = $this->json('post', 'v1/user/'.$userData1['id'].'/avatar/crop', [], ['X-Auth'=>$accessToken2]);
        $response->assertStatus(403);

    }

}
