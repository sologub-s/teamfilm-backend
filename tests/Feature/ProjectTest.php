<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use Tests\Feature\AbstractTestCase;

use Illuminate\Support\Facades\Mail;

class ProjectTest extends AbstractTestCase
{

    public function testCreateUser () {

        Mail::fake();

        $userJsonDecoded = (array) json_decode(file_get_contents(dirname(__FILE__).'/UserTest/user.json'), true);

        $response = $this->json('POST', 'v1/user', $userJsonDecoded);
        $response->assertStatus(200);
        $userData = json_decode($response->getContent(), true)['user'];
        $response = $this->json('POST', 'v1/user/activate/'.$userData['activation_token']);
        $response
            ->assertStatus(200)
            ->assertJsonFragment([
                'is_active' => true,
            ])
        ;
        $response = $this->json('POST', 'v1/user/login', ['login' => [
            'email' => $userJsonDecoded['user']['email'],
            'password' => $userJsonDecoded['user']['password'],
            'access_token_expire_at' => 9999999999,
        ],]);
        $accessToken = json_decode($response->getContent(), true)['login']['access_token'];

        return ['user' => $userData, 'access_token' => $accessToken];

    }

    /**
     * @param $userInfo
     * @depends testCreateUser
     */
    public function testCreateProject ($userInfo) {

        $projectJsonDecoded = (array) json_decode(file_get_contents(dirname(__FILE__).'/ProjectTest/project.json'), true);
        $projectJsonDecoded['project']['user_id'] = $userInfo['user']['id'];
        $response = $this->json('POST', 'v1/project', $projectJsonDecoded, ['X-Auth'=>$userInfo['access_token']]);
        $response
            ->assertStatus(200)
            ->assertJson($projectJsonDecoded)
        ;
        $projectData = json_decode($response->getContent(), true)['project'];

        $projectJsonDecoded['project']['title'] = 'Project 1';
        $response = $this->json('PATCH', 'v1/project/'.$projectData['id'], $projectJsonDecoded, ['X-Auth'=>$userInfo['access_token']]);
        $response
            ->assertStatus(200)
            ->assertJson($projectJsonDecoded)
        ;

        $file = dirname(__FILE__).'/ProjectTest/logo.gif';
        $result = $this->uploadFile(env('APP_URL').'/v1/project/'.$projectData['id'].'/logo'.'?testing', $file, $userInfo['access_token'], 'logo[]');
        $this->assertEquals($result['code'], 200);
        $logoJson = json_decode($result['content'], true);
        $this->assertArrayHasKey('logo', $logoJson);

        $logoResponse = $this->json('GET', 'v1/project/'.$projectData['id'].'/logo',[],['X-Auth'=>$userInfo['access_token']])->assertStatus(200);
        $logoContent = $logoResponse->getContent();
        $logo = json_decode($logoContent, true);
        $this->assertTrue(is_array($logo['logo']));
        $this->assertArrayHasKey('identity', $logo['logo']);
        $this->assertArrayHasKey('name', $logo['logo']);
        $this->assertArrayHasKey('url', $logo['logo']);
        $this->assertEquals($logoJson['logo']['identity'], $logo['logo']['identity']);
        $this->assertEquals($logoJson['logo']['name'], $logo['logo']['name']);
        $this->assertEquals($logoJson['logo']['url'], $logo['logo']['url']);

        $this->assertTrue($this->is_url_exist((config('services.storage.url') . $logo['logo']['url'])));

        $this->json('DELETE', 'v1/project/'.$projectData['id'].'/logo',[],['X-Auth'=>$userInfo['access_token']])->assertStatus(200);
        $this->assertFalse($this->is_url_exist((config('services.storage.url') . $logo['logo']['url'])));

        $projectJsonDecoded2 = $projectJsonDecoded;
        $projectJsonDecoded2['project']['title'] = 'Project 2';

        $response = $this->json('POST', 'v1/project', $projectJsonDecoded2, ['X-Auth'=>$userInfo['access_token']]);
        $response
            ->assertStatus(200)
            ->assertJson($projectJsonDecoded2)
        ;
        $projectData2 = json_decode($response->getContent(), true)['project'];

        $response = $this->json('GET', 'v1/project/list?filter[user_id]='.$userInfo['user']['id'], [], ['X-Auth'=>$userInfo['access_token']]);
        $response->assertStatus(200);
        $projects = (array) json_decode($response->getContent(), true);
        $this->assertEquals(2, sizeof($projects['projects']));
        $this->assertEquals('Project 1', $projects['projects'][0]['title']);
        $this->assertEquals('Project 2', $projects['projects'][1]['title']);

        $response = $this->json('DELETE', 'v1/project/'.$projectData2['id'], [], ['X-Auth'=>$userInfo['access_token']]);
        $response->assertStatus(200);

        $response = $this->json('GET', 'v1/project/'.$projectData2['id'], [], ['X-Auth'=>$userInfo['access_token']]);
        $response->assertStatus(404);

    }

}
