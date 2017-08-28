<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskCreateRequest;
use App\Services\ApiService;
use Lang;
use App;

class TaskController extends Controller
{

    protected $apiService;

    public function __construct(ApiService $apiService)
    {
        $this->apiService = $apiService;
    }


    public function create() {
        return view('task.create');
    }

    public function store(TaskCreateRequest $taskCreateRequest) {
        $result = $this->apiService->pushTaskToNetwork($taskCreateRequest->input());
        //dd($result);
        if ($result['status'])
            $taskCreateRequest->session()->flash('alert-success', Lang::get('task.created_success_msg'));
        else
            $taskCreateRequest->session()->flash('alert-danger', Lang::get('task.created_failed_msg'));
        return redirect()->route('task_create');
    }

    public function index() {
        $result = $this->apiService->getAllTasks();
        $tasks = $result['tasks'];
        return view('task.list', compact('tasks'));
    }

    public function view($taskId) {
        $result = $this->apiService->getTaskById($taskId);
        $task = $result['task'];
        return view('task.view', compact('task'));
    }

}
