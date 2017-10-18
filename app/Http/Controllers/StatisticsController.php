<?php
/**
 * Created by PhpStorm.
 * User: Aurimas
 * Date: 2017-09-17
 * Time: 10:54
 */

namespace App\Http\Controllers;

use App\Services\ChartsService;
use Illuminate\Http\Request;
use Lava;
use App\Services\Api\StatisticsService;
use App\Helpers\AppHelper;

class StatisticsController extends Controller
{

    private $statisticsService;
    private $chartService;

    public function __construct(StatisticsService $statisticsService, ChartsService $chartsService)
    {
        $this->statisticsService = $statisticsService;
        $this->chartService = $chartsService;
    }

    public function index(Request $request) {
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
        $result = $this->statisticsService->getSystemStatistics();
        //dd($result);
        $statistics = $result["body"];
        $activeDataContractCounts = null;
        if (array_key_exists("activeDataContractCounts", $statistics)) {
            $activeDataContractCounts = $statistics["activeDataContractCounts"];
        }
        $this->chartService->generateDataContractsCountChart($activeDataContractCounts, $params);

        $activeNodeCounts = null;
        if (array_key_exists("activeNodeCounts", $statistics)) {
            $activeNodeCounts = $statistics["activeNodeCounts"];
        }
        $this->chartService->generateNodeCountChart($activeNodeCounts, $params);

        $taskResultTimes = null;
        if (array_key_exists("taskResultTimes", $statistics)) {
            $taskResultTimes = $statistics["taskResultTimes"];
        }
        $this->chartService->generateTaskResultsChart($taskResultTimes, $params);

        return view("statistics.view", compact("statistics", "dataContractChart",
            "nodeCountChart", "taskResultsChart",
            "period", "interval"));
    }

    public function statsRaw() {
        $result = $this->statisticsService->getSystemStatistics();
        dd($result);
    }

    /*public function test(Request $request) {
        $handle = fopen(__DIR__.'/node_counts.txt', "r");
        $activeNodeCounts = [];
        if ($handle) {
            while (($line = fgets($handle)) !== false) {
                //echo "'".trim($line)."'<br>";
                $elems = explode(" => ", trim($line, " \r\n"));
                $activeNodeCounts[(int)$elems[0]] = (int)$elems[1];
            }

            fclose($handle);
        } else {
            // error opening the file.
        }
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
        //dd($activeNodeCounts);

        $this->chartService->generateDataContractsCountChart(null, $params);

        $statistics["activeNodeCounts"] = $activeNodeCounts;
        $this->chartService->generateNodeCountChart($activeNodeCounts, $params);

        $this->chartService->generateTaskResultsChart(null, $params);

        return view("statistics.view", compact("statistics", "dataContractChart",
            "nodeCountChart", "taskResultsChart",
            "period", "interval"));

    }*/

}