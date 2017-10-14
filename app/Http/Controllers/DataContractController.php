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
        $input = $request->json()->all();
        $input["id"] = 5;
        return response()->json($input);
    }
}
