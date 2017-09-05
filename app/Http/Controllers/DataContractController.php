<?php

namespace App\Http\Controllers;

use App\Http\Requests\DataContractRequest;
use App\Services\ApiService;
use Lang;
use App;

class DataContractController extends Controller
{

    protected $apiService;

    public function __construct(ApiService $apiService)
    {
        $this->apiService = $apiService;
    }


    public function create() {
        return view('data_contract.create');
    }

    public function store(DataContractRequest $dataContractRequest) {
        $result = $this->apiService->sendDataContract($dataContractRequest->input());
        //dd($result);
        if ($result['status'])
            $dataContractRequest->session()->flash('alert-success', Lang::get('general.datac.created_success_msg'));
        else
            $dataContractRequest->session()->flash('alert-danger', Lang::get('general.datac.created_failed_msg'));
        return redirect()->route('data_contracts');
    }

    public function index() {
        $result = $this->apiService->getAllDataContracts();
        $dataContracts = $result['data_contracts'];
        return view('data_contract.list', compact('dataContracts'));
    }

    public function view($dataContractId) {
        $result = $this->apiService->getDataContractById($dataContractId);
        //dd($result);
        $dataContract = $result['data_contract'];
        return view('data_contract.view', compact('dataContract'));
    }

}
