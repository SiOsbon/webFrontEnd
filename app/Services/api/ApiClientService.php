<?php
/**
 * Created by PhpStorm.
 * User: Aurimas
 * Date: 2017-09-23
 * Time: 08:37
 */

namespace App\Services\Api;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

class ApiClientService
{
    private $apiUri;

    public function __construct()
    {
        $this->apiUri = config('api.uri');
    }

    public function requestGet($params) {
        $client = new Client();
        try {
            $uri = $this->apiUri.$params["path"];
            $r = $client->get($uri);
            $result['body'] = json_decode($r->getBody(), true);
            $result['status'] = true;
        } catch (GuzzleException $e) {
            $response = $e->getResponse();
            $result['status'] = false;
            $result['body'] = [];
            if ($response)
                $result['error'] = $response->getBody()->getContents();
            else
                $result['error'] = $e->getMessage();
        }
        return $result;
    }

    public function requestJson($params){
        $client = new Client();
        try {
            $r = $client->post($this->apiUri.$params["path"], [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json'
                ],
                'json' => $params["body"]
                /*'form_params' => [
                    'dataContract' => $jsonDataContract
                ]*/
            ]);
            $result['body'] = json_decode($r->getBody(), true);
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