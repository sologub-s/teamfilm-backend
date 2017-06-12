<?php

namespace Tests\Feature;

use Tests\TestCase;

abstract class AbstractTestCase extends TestCase
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
    protected function uploadFile(String $url, String $path, String $access_token, $filename = 'avatar[]') {

        // initialise the curl request
        $request = curl_init($url);

        // send a file
        curl_setopt($request, CURLOPT_POST, true);
        curl_setopt($request, CURLOPT_HEADER, true);
        curl_setopt($request, CURLOPT_HTTPHEADER, ['X-Auth: '.$access_token,]);
        curl_setopt($request, CURLOPT_POSTFIELDS, [
            $filename => new \CURLFile($path),
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
}