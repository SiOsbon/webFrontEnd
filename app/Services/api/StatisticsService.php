<?php
/**
 * Created by PhpStorm.
 * User: Aurimas
 * Date: 2017-09-17
 * Time: 10:56
 */

namespace App\Services\Api;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

class StatisticsService
{

    private $apiClientService;

    public function __construct(ApiClientService $apiClientService)
    {
        $this->apiClientService = $apiClientService;
    }

    public function getSystemStatistics() {
        $params["path"] = "/statistics/";
        $result = $this->apiClientService->requestGet($params);
        return $result;
    }

}