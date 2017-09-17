<?php
/**
 * Created by PhpStorm.
 * User: Aurimas
 * Date: 2017-09-17
 * Time: 10:54
 */

namespace App\Http\Controllers;

use Lava;
use App\Services\Api\StatisticsService;

class StatisticsController extends Controller
{

    private $statisticsService;

    public function __construct(StatisticsService $statisticsService)
    {
        $this->statisticsService = $statisticsService;
    }

    public function index() {
        $result = $this->statisticsService->getSystemStatistics();
        $statistics = $result["statistics"];

        $interval = 60 * 60;
        $current = time();
        $dt = new \DateTime();
        $dt->setTimestamp($current);
        echo "Currently: ".$dt->format('Y-m-d H:i:s')."<br>";
        //dd($result);
        $activeDataContractCounts = $statistics["activeDataContractCounts"];
        $activeTasksCounts = $statistics["activeTasksCounts"];
        ksort($activeDataContractCounts);
        ksort($activeTasksCounts);

        $dataContractChart = \Lava::DataTable();
        $dataContractChart->addStringColumn('')
            ->addNumberColumn('Count');

        $rows = [];
        $max = 0;
        for ($i=0; $i<24; $i++) {
            $newTs1 = $current - $interval * $i;
            $newTs2 = $current - $interval * ($i + 1);
            $cnt = 0;
            foreach ($activeDataContractCounts as $key => $value) {
                if ($key / 1000 <= $newTs1 and $key / 1000 >= $newTs2) {
                    $cnt = $value;
                    if ($cnt > $max)
                        $max = $cnt;
                    break;
                }
            }
            $dt = new \DateTime();
            $dt->setTimestamp($newTs2);
            //echo $dt->format('Y-m-d H')."<br>";
            $rows[] = [$dt->format('H').":00", $cnt];
            //echo "<br>";
        }
        $rows = array_reverse($rows);
        foreach ($rows as $row)
            $dataContractChart->addRow($row);

        $ticks = [];
        for ($i=0; $i<=$max + 1; $i++) {
            $ticks[] = $i;
        }

        \Lava::ColumnChart('dataContractChart', $dataContractChart, [
            'title' => 'Data contracts',
            'vAxis' => [
                'format' => '#.#',
                'ticks' =>  $ticks
            ],
            'titleTextStyle' => [
                'color'    => '#eb6b2c',
                'fontSize' => 14
            ]
        ]);
        //dd($result);

        $tasksChart = \Lava::DataTable();
        $tasksChart->addStringColumn('')
            ->addNumberColumn('Count');

        $rows = [];
        $max = 0;
        for ($i=0; $i<24; $i++) {
            $newTs1 = $current - $interval * $i;
            $newTs2 = $current - $interval * ($i + 1);
            $cnt = 0;
            foreach ($activeTasksCounts as $key => $value) {
                if ($key / 1000 <= $newTs1 and $key / 1000 >= $newTs2) {
                    $cnt = $value;
                    if ($cnt > $max)
                        $max = $cnt;
                    break;
                }
            }
            $dt = new \DateTime();
            $dt->setTimestamp($newTs2);
            //echo $dt->format('Y-m-d H')."<br>";
            $rows[] = [$dt->format('H').":00", $cnt];
            //echo "<br>";
        }
        $rows = array_reverse($rows);
        foreach ($rows as $row)
            $tasksChart->addRow($row);

        $ticks = [];
        for ($i=0; $i<=$max + 1; $i++) {
            $ticks[] = $i;
        }

        \Lava::ColumnChart('tasksChart', $tasksChart, [
            'title' => 'Active tasks count',
            //'vAxis' => ['format' => '0'],
            'vAxis' => [
                'format' => '#.#',
                'ticks' =>  $ticks
            ],
            'gridlines' => ['count' => -1],
            'sortValues' => true,
            'titleTextStyle' => [
                'color'    => '#eb6b2c',
                'fontSize' => 14
            ]
        ]);

        return view("statistics.view", compact("statistics", "dataContractChart", "tasksChart"));
    }

}