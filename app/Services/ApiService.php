<?php

namespace App\Services;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

class ApiService
{

    public function getTaskById($taskId) {
        $client = new Client();
        try {
            $uri = config('app.uri_task').'/'.$taskId;
            $r = $client->get($uri);
            $task = json_decode($r->getBody(), true);
            $result['task'] = $task;
            $result['status'] = true;
        } catch (GuzzleException $e) {
            $response = $e->getResponse();
            $result['status'] = false;
            $result['task'] = null;
            if ($response)
                $result['error'] = $response->getBody()->getContents();
            else
                $result['error'] = $e->getMessage();
        }
        return $result;
    }

    public function getAllDataContracts() {
        $client = new Client();
        try {
            $r = $client->get(config('api.uri_data_contracts'), []);
            $dataContracts = json_decode($r->getBody(), true);
            //dd($dataContracts);
            $result['data_contracts'] = $dataContracts;
            $result['status'] = true;
        } catch (GuzzleException $e) {
            $response = $e->getResponse();
            $result['status'] = false;
            $result['data_contracts'] = [];
            if ($response)
                $result['error'] = $response->getBody()->getContents();
            else
                $result['error'] = $e->getMessage();
        }
        return $result;
    }

    public function pushTaskToNetwork($input) {
        $jsonTask= $input['task'];
        $result = [];
        $client = new Client();
        try {
            $r = $client->post(config('app.uri_task_to_net'), [
                'form_params' => [
                    'task' => $jsonTask
                ]
            ]);
            $task = json_decode($r->getBody(), true);
            $result['task'] = $task;
            $result['status'] = true;
        } catch (GuzzleException $e) {
            $response = $e->getResponse();
            $result['status'] = false;
            if ($response)
                $result['error'] = $response->getBody()->getContents();
            else
                $result['error'] = $e->getMessage();
        }
        return $result;
    }

}