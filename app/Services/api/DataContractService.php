<?php

namespace App\Services\Api;

use App\Services\Api\ApiClientService;

class DataContractService
{

    private $apiClientService;

    public function __construct(ApiClientService $apiClientService)
    {
        $this->apiClientService = $apiClientService;
    }

    public function getDataContractById($dataContractId) {
        $params["path"] = "/data-contract/".$dataContractId;
        $result = $this->apiClientService->requestGet($params);
        return $result;
    }

    public function getAllDataContracts() {
        $params["path"] = "/data-contracts/";
        $result = $this->apiClientService->requestGet($params);
        return $result;
    }

    public function sendDataContract($input) {
        $params["path"] = "/data-contract/";
        $params["body"] = $input;
        $result = $this->apiClientService->requestJson($params);
        return $result;
    }

    public function sendDataContract2($input) {
        $params["path"] = "/data-contract/";
        $params["body"] = json_decode($input['json_data_contract']);
        $result = $this->apiClientService->requestJson($params);
        return $result;
    }

    public function start($dataContractId) {
        $params["path"] = "/data-contract/start/".$dataContractId;
        $result = $this->apiClientService->requestGet($params);
        return $result;
    }

    public function stop($dataContractId) {
        $params["path"] = "/data-contract/stop/".$dataContractId;
        $result = $this->apiClientService->requestGet($params);
        return $result;
    }

    public function downloadResult($dataContractId) {
        $params["path"] = "/data-contract/results/".$dataContractId;
        $result = $this->apiClientService->requestGet($params);
        //dd($result);
        return $result;
    }

}