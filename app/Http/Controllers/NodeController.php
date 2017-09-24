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
        $nodes = $result["body"];
        return view('node.list', compact("nodes"));
    }

    public function view(Request $request, $nodeId) {
        $input = $request->input();
        if (array_key_exists("interval", $input))
            $params['interval'] = $input["interval"];
        else
            $params['interval'] = 60 * 60;
        if (array_key_exists("period", $input))
            $params['period'] = $input["period"];
        else
            $params['period'] = 60 * 60 * 24;

        $interval = $params["interval"];
        $period = $params["period"];

        $result = $this->nodeService->getNode($nodeId);
        //dd($result);
        $node = $result["body"];
        $executedTaskTimes = null;

        if (array_key_exists("executedTaskTimes", $node)) {
            $executedTaskTimes = $node["executedTaskTimes"];
        }
        $this->chartsService->generateNodeExecutedTasksChart($node["executedTaskTimes"], $params);

        return view('node.view', compact("node", "nodeTaskChart", "interval", "period"));
    }

}
