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

    public function getAllNodes() {
        $client = new Client();
        try {
            $r = $client->get(config('api.uri_nodes'), []);
            $nodes = json_decode($r->getBody(), true);
            //dd($dataContracts);
            $result['nodes'] = $nodes;
            $result['status'] = true;
        } catch (GuzzleException $e) {
            $response = $e->getResponse();
            $result['status'] = false;
            $result['nodes'] = [];
            if ($response)
                $result['error'] = $response->getBody()->getContents();
            else
                $result['error'] = $e->getMessage();
        }
        return $result;
    }

    public function getNode($nodeId) {
        $client = new Client();
        try {
            $r = $client->get(config('api.uri_node').$nodeId, []);
            $node = json_decode($r->getBody(), true);
            $result['node'] = $node;
            $result['status'] = true;
        } catch (GuzzleException $e) {
            $response = $e->getResponse();
            $result['status'] = false;
            $result['nodes'] = [];
            if ($response)
                $result['error'] = $response->getBody()->getContents();
            else
                $result['error'] = $e->getMessage();
        }
        return $result;
    }

}