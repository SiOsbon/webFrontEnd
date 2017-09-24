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
        return view('data_contract.create');
    }

    public function store(DataContractRequest $dataContractRequest) {
        $result = $this->dataContractService->sendDataContract($dataContractRequest->input());
        if ($result['status'])
            $dataContractRequest->session()->flash('alert-success', Lang::get('general.datac.created_success_msg'));
        else
            $dataContractRequest->session()->flash('alert-danger', Lang::get('general.datac.created_failed_msg'));
        return redirect()->route('data_contracts');
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

    public function results(Request $request, $dataContractId) {
        $result = $this->dataContractService->downloadResult($dataContractId);
        $resultTasks = $result["body"];
        //dd($resultTasks);
        return view('data_contract.results', compact('resultTasks'));
    }
}
