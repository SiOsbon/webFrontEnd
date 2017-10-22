<?php

namespace App\Http\Controllers;

use App\Http\Requests\DataContractRequest;
use App\Services\Api\DataContractService;
use Illuminate\Http\Request;
use Lang;
use App;

class DataContractController extends Controller
{

    protected $dataContractService;

    public function __construct(DataContractService $dataContractService)
    {
        $this->dataContractService = $dataContractService;
    }

    public function create() {
        return view('data_contract.create', ["submit_url" => route('data_contract_store_ajax'), "redirect_url" => route('data_contract_create')]);
    }

    public function create2() {
        return view('data_contract.create2');
    }

    public function findCreate() {
        return view('data_contract.create', ["submit_url" => route('data_contract_find_store_ajax'), "redirect_url" => route('data_contract_find_create')]);
    }

    public function store(DataContractRequest $dataContractRequest)
    {
        $result = $this->dataContractService->sendDataContract2($dataContractRequest->input());
        if ($result['status'])
            $dataContractRequest->session()->flash('alert-success', Lang::get('general.datac.created_success_msg'));
        else
            $dataContractRequest->session()->flash('alert-danger', Lang::get('general.datac.created_failed_msg'));
        return redirect()->route('data_contracts');
    }

    public function storeAjax(Request $request) {
        $result = $this->dataContractService->sendDataContract($request->input());
        return response()->json($result);
    }

    public function findStoreAjax(Request $request) {
        $result = $this->dataContractService->findUpdloadDataContract($request->input());
        //dd($result);
        return response()->json($result);
    }

    public function index() {
        $result = $this->dataContractService->getAllDataContracts();
        $dataContracts = $result['body'];
        return view('data_contract.list', compact('dataContracts'));
    }

    public function view($dataContractId) {
        $result = $this->dataContractService->getDataContractById($dataContractId);
        $dataContract = $result['body'];
        return view('data_contract.view', compact('dataContract'));
    }

    public function start(Request $request, $dataContractId) {
        $result = $this->dataContractService->start($dataContractId);
        if ($result['status'])
            $request->session()->flash('alert-success', Lang::get('general.datac.start_success_msg',
                ['contract_name' => $result['body']['name']]));
        else
            $request->session()->flash('alert-danger', Lang::get('general.datac.start_failed_msg'));
        return redirect()->route('data_contracts');
    }

    public function stop(Request $request, $dataContractId) {
        $result = $this->dataContractService->stop($dataContractId);
        if ($result['status'])
            $request->session()->flash('alert-success', Lang::get('general.datac.stop_success_msg',
                ['contract_name' => $result['body']['name']]));
        else
            $request->session()->flash('alert-danger', Lang::get('general.datac.stop_failed_msg'));
        return redirect()->route('data_contracts');
    }

    public function results($dataContractId, $page = 0) {
        $count = 5;
        $result = $this->dataContractService->downloadResult($dataContractId, $page, $count);
        //dd($result);
        $body = $result["body"];
        $contractName = $body["dataContractName"];
        if (array_key_exists("pagenatedResults", $body)) {
            $resultTasks = $body["pagenatedResults"];
            $allCount = $body["allCount"];
        } else {
            $resultTasks = [];
            $allCount = 0;
        }
        return view('data_contract.results', compact('resultTasks', 'allCount', 'page', 'count', 'dataContractId',
            'contractName'));
    }

    public function demoStore(Request $request) {
        $input = $request->input();
        if (array_key_exists("fields-list", $input)) {
            $fields_list = json_decode($input["fields-list"]);
            $fields = $fields_list->fields;
            asort($fields);
            $fields = array_unique($fields);
            //dd($fields);
            $field_xpaths = [
                "name" => "/html/body/section/div/div/div/div/a[3]",
                "company" => "/html/body/section/div/div/div/div/a[2]",
                "photo" => "/html/body/section/div/div/div/div/a",
                "rating" => "/html/body/section/div/div/div/div/div[2]/a",
                "review-count" => "/html/body/section/div/div/div/div/div[2]/a[2]",
                "price" => "/html/body/section/div/div/div/div/a[4]/span",
                "in-stock" => "/html/body/section/div/div/div/div/a[5]"
            ];

            $task["targetURL"] = "http://mvp.daratus.com:8080/demo";
            $task["type"] = "GetData";
            //$task["urls"] = ["/html/body/section/div/div/div/div/a[6]"];
            $task["urls"] = [];
            $data = new \stdClass();
            $n = "";
            foreach ($fields as $field) {
                if (array_key_exists($field, $field_xpaths)) {
                    $data->$field = $field_xpaths[$field];
                    $n .= strtoupper(substr($field, 0, 1));
                }
            }
            $dataContract["name"] = "Demo contract (".$n.")";
            $task["data"] = $data;
            $dataContract["tasks"][] = $task;
            $result = $this->dataContractService->findUpdloadDataContract($dataContract);
            if ($result["status"]) {
                return redirect()->route('data_contract_results', ["dataContractId" => $result["body"]["dataContract"]["id"]]);
                //return response()->json(["id" => $result["body"]["dataContract"]["id"]]);
            }
        }
        return redirect()->route('home');
        //return response()->json(["id" => 0]);
    }
}
