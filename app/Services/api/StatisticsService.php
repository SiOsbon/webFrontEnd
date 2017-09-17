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

    public function getSystemStatistics() {
        $client = new Client();
        try {
            $r = $client->get(config('api.uri_statistics'), []);
            $statistics = json_decode($r->getBody(), true);
            //dd($dataContracts);
            $result['statistics'] = $statistics;
            $result['status'] = true;
        } catch (GuzzleException $e) {
            $response = $e->getResponse();
            $result['status'] = false;
            $result['statistics'] = "";
            if ($response)
                $result['error'] = $response->getBody()->getContents();
            else
                $result['error'] = $e->getMessage();
        }
        return $result;
    }

}