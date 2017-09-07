<?php

namespace App\Services;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

class ApiService
{
    /* todo refactor, move to api/DataContractService */

    public function getDataContractById($dataContractId) {
        $client = new Client();
        try {
            $uri = config('api.uri_data_contract').$dataContractId;
            $r = $client->get($uri);
            $dataContract = json_decode($r->getBody(), true);
            $result['data_contract'] = $dataContract;
            $result['status'] = true;
        } catch (GuzzleException $e) {
            $response = $e->getResponse();
            $result['status'] = false;
            $result['data_contract'] = null;
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

    public function sendDataContract($input) {
        $jsonDataContract= $input['data_contract'];
        $result = [];
        $client = new Client();
        try {
            $r = $client->post(config('api.uri_data_contract'), [
                'form_params' => [
                    'dataContract' => $jsonDataContract
                ]
            ]);
            $dataContract = json_decode($r->getBody(), true);
            $result['data_contract'] = $dataContract;
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