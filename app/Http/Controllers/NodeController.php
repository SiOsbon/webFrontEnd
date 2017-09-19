<?php

namespace App\Http\Controllers;

use App\Services\Api\NodeService;
use App\Services\ChartsService;
use Illuminate\Http\Request;

class NodeController extends Controller
{

    protected $nodeService;
    private $chartsService;

    public function __construct(NodeService $nodeService,
                                ChartsService $chartsService)
    {
        $this->nodeService = $nodeService;
        $this->chartsService = $chartsService;
    }

    public function index() {
        $result = $this->nodeService->getAllNodes();
        $nodes = $result["nodes"];
        return view('node.list', compact("nodes"));
    }

    public function view($nodeId) {
        $result = $this->nodeService->getNode($nodeId);
        //dd($result);
        $node = $result["node"];
        $this->chartsService->generateNodeExecutedTasksChart($node["executedTaskTimes"]);
        return view('node.view', compact("node", "nodeTaskChart"));
    }

}
