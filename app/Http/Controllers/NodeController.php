<?php

namespace App\Http\Controllers;

use App\Http\Requests\NodeRegistrationRequest;
use App\Mail\NodeRegistrationMail;
use App\Services\Api\NodeService;
use App\Services\ChartsService;
use Illuminate\Http\Request;
use Mail;
use Lang;

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
        if ($result["body"])
            $nodes = $result["body"];
        else
            $nodes = [];
        return view('node.list', compact("nodes"));
    }

    public function viewByCode(Request $request, $nodeCode) {
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

        $result = $this->nodeService->getNodeByCode($nodeCode);
        //dd($result);
        $node = $result["body"];
        $executedTaskTimes = null;

        if (array_key_exists("executedTaskTimes", $node)) {
            $executedTaskTimes = $node["executedTaskTimes"];
        }
        $this->chartsService->generateNodeExecutedTasksChart($executedTaskTimes, $params);

        return view('node.view', compact("node", "nodeTaskChart", "interval", "period"));
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
        $this->chartsService->generateNodeExecutedTasksChart($executedTaskTimes, $params);

        return view('node.view', compact("node", "nodeTaskChart", "interval", "period"));
    }

    public function registration($referralCode = "") {
        return view('node.registration', ["referralCode" => $referralCode]);
    }

    public function register(NodeRegistrationRequest $nodeRegistrationRequest) {
        $input = $nodeRegistrationRequest->input();
        $result = $this->nodeService->registerNode($input);
        $node = $result["body"];
        Mail::to($node["userEmail"])->send(new NodeRegistrationMail($node));
        if (Mail::failures()) {
            $nodeRegistrationRequest->session()->flash('alert-success',
                Lang::get('general.mail.sent_fail', ['address' => $node["userEmail"]]));
        } else {
            $nodeRegistrationRequest->session()->flash('alert-success',
                Lang::get('general.mail.sent_success', ['address' => $node["userEmail"]]));
        }
        return redirect()->route('node-registration', ["referralCode" => $node["shortCode"]]);
    }


}
