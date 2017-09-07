<?php

namespace App\Http\Controllers;

use App\Services\Api\NodeService;
use Illuminate\Http\Request;

class NodeController extends Controller
{

    protected $nodeService;

    public function __construct(NodeService $nodeService)
    {
        $this->nodeService = $nodeService;
    }

    public function index() {
        $result = $this->nodeService->getAllNodes();
        $nodes = $result["nodes"];
        return view('node.list', compact("nodes"));
    }

}
