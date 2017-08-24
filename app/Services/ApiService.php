<?php

namespace App\Services;

class ApiService
{

    public function pushTaskToNetwork($input) {
        $task = new \stdClass();
        $task->taskId = rand(1000, 9999);
        return $task;
    }

}