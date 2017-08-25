<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskCreateRequest;
use App\Services\ApiService;
use Illuminate\Http\Request;
use Lang;
use App;

class TaskController extends Controller
{

    protected $apiService;

    public function __construct(ApiService $apiService)
    {
        $this->apiService = $apiService;
    }


    public function index() {
        return view('task.create');
    }

    public function create(TaskCreateRequest $taskCreateRequest) {
        //dd($taskCreateRequest->input());
        $task = $this->apiService->pushTaskToNetwork($taskCreateRequest->input());
        $taskCreateRequest->session()->flash('alert-success', Lang::get('task.created_success_msg'));
        //dd($task);
        return redirect()->route('home');
    }

}
