<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Api\NodeService;
use Mail;
use Lang;
use URL;
use App\Mail\NodeRegistrationMail;

class BackEndApiController extends Controller
{

    private $nodeService;

    public function __construct(NodeService $nodeService)
    {
        $this->nodeService = $nodeService;
    }

    public function registerNode(Request $request) {
        $node = $request->input();
        if (filter_var($node["userEmail"], FILTER_VALIDATE_EMAIL)) {
            $node["currentTask"]["data"] = new \stdClass();
            $result = $this->nodeService->registerNode($node);
            $result["body"]["currentTask"]["data"] = new \stdClass();
            $node = $result["body"];
            Mail::to($node["userEmail"])->send(new NodeRegistrationMail($node));
            if (Mail::failures()) {
                $result["message"] = Lang::get('general.mail.sent_fail', ['address' => $node["userEmail"]]);
            } else {
                $result["message"] = Lang::get('general.mail.sent_success', ['address' => $node["userEmail"]]);
            }
        } else {
            $result["status"] = false;
            $result["message"] = "Please provide valid email address";
        }
        return response()->json($result);
    }

    public function sendReferralLink(Request $request) {
        $node = $request->input();
        $result["body"] = URL::route('node-registration', ["referralCode" => $node["shortCode"]]);
        $result["status"] = true;
        return response()->json($result);
    }

}
