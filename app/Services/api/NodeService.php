<?php
/**
 * Created by PhpStorm.
 * User: Aurimas
 * Date: 2017-09-07
 * Time: 17:20
 */

namespace App\Services\Api;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

class NodeService
{

    private $apiClientService;

    public function __construct(ApiClientService $apiClientService)
    {
        $this->apiClientService = $apiClientService;
    }

    public function getAllNodes() {
        $params["path"] = "/nodes/";
        $result = $this->apiClientService->requestGet($params);
        return $result;
    }

    public function getNode($nodeId) {
        $params["path"] = "/node/".$nodeId;
        $result = $this->apiClientService->requestGet($params);
        return $result;
    }

    public function getNodeByCode($nodeCode) {
        $params["path"] = "/node/code/".$nodeCode;
        $result = $this->apiClientService->requestGet($params);
        return $result;
    }

    public function registerNode($input) {
        $params["path"] = "/node/register";
        $params["body"] = $input;
        $result = $this->apiClientService->requestJson($params);
        return $result;
    }

}