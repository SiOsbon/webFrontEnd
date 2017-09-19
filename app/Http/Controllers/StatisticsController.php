<?php
/**
 * Created by PhpStorm.
 * User: Aurimas
 * Date: 2017-09-17
 * Time: 10:54
 */

namespace App\Http\Controllers;

use App\Services\ChartsService;
use Lava;
use App\Services\Api\StatisticsService;

class StatisticsController extends Controller
{

    private $statisticsService;
    private $chartService;

    public function __construct(StatisticsService $statisticsService, ChartsService $chartsService)
    {
        $this->statisticsService = $statisticsService;
        $this->chartService = $chartsService;
    }

    public function index() {
        $result = $this->statisticsService->getSystemStatistics();
        $statistics = $result["statistics"];

        $activeDataContractCounts = $statistics["activeDataContractCounts"];
        $this->chartService->generateDataContractsCountChart($activeDataContractCounts);

        $activeTasksCounts = $statistics["activeTasksCounts"];
        $this->chartService->generateTasksCountChart($activeTasksCounts);

        return view("statistics.view", compact("statistics", "dataContractChart", "tasksChart"));
    }

}