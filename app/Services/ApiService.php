<?php

namespace App\Services;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

class ApiService
{

    public function pushTaskToNetwork($input) {
        $bodyJson = $input['body'];
        //var_dump($bodyJson);
        $client = new Client(); //GuzzleHttp\Client
        $result = $client->post(config('app.uri_task_to_net'), [
            'form_params' => [
                'body' => $bodyJson
            ]
        ]);
        //var_dump($result);
        $task = json_decode($result->getBody(), true);
        return $task;
    }

}