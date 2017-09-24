<?php
/**
 * Created by PhpStorm.
 * User: Aurimas
 * Date: 2017-09-19
 * Time: 14:30
 */

namespace App\Services;


class ChartsService
{

    private $statisticalDataService;

    public function __construct(StatisticalDataService $statisticalDataService)
    {
        $this->statisticalDataService = $statisticalDataService;
    }

    public function generateNodeExecutedTasksChart($taskCounts, $params) {
        $dataTable = \Lava::DataTable();
        $dataTable->addStringColumn('')
            ->addNumberColumn('Count');
        $timeZone = 3 * 60 * 60; // 3 hours in seconds
        $vAxis["ticks"] = [1];
        if ($taskCounts) {
            $result = $this->statisticalDataService->calculateGroupedDataForChart($taskCounts, $timeZone,
                $params["interval"], $params["period"]);
            foreach ($result['rows'] as $row)
                $dataTable->addRow($row);
            //$vAxis['format'] = '#.#';
            $vAxis["ticks"] = $result["ticks"];
        }
        \Lava::ColumnChart('nodeTaskChart', $dataTable, [
            'title' => 'Node executed task count',
            'vAxis' => $vAxis,
            'titleTextStyle' => [
                'color'    => '#eb6b2c',
                'fontSize' => 14
            ]
        ]);
    }

    public function generateDataContractsCountChart($dataContractCounts, $params) {
        $dataTable = \Lava::DataTable();
        $dataTable->addStringColumn('')
            ->addNumberColumn('Count');
        $timeZone = 3 * 60 * 60; // 3 hours in seconds
        $vAxis["ticks"] = [1];
        if ($dataContractCounts) {
            $result = $this->statisticalDataService->calculateDataForChart($dataContractCounts, $timeZone,
                $params["interval"], $params["period"]);
            foreach ($result['rows'] as $row)
                $dataTable->addRow($row);

            $vAxis["ticks"] = $result["ticks"];
        }
        \Lava::ColumnChart('dataContractChart', $dataTable, [
            'title' => 'Active data contracts',
            'vAxis' => $vAxis,

            'titleTextStyle' => [
                'color'    => '#eb6b2c',
                'fontSize' => 14
            ]
        ]);
    }

    public function generateNodeCountChart($nodeCounts, $params) {
        $dataTable = \Lava::DataTable();
        $dataTable->addStringColumn('')
            ->addNumberColumn('Count');
        $timeZone = 3 * 60 * 60; // 3 hours in seconds

        $vAxis["ticks"] = [1];
        if ($nodeCounts) {
            $result = $this->statisticalDataService->calculateDataForChart($nodeCounts, $timeZone,
                $params["interval"], $params["period"]);
            foreach ($result['rows'] as $row)
                $dataTable->addRow($row);
            $vAxis["ticks"] = $result["ticks"];
        }

        \Lava::ColumnChart('nodeCountChart', $dataTable, [
            'title' => 'Active node counts',
            'vAxis' => $vAxis,

            'titleTextStyle' => [
                'color'    => '#eb6b2c',
                'fontSize' => 14
            ]
        ]);
    }

    public function generateTaskResultsChart($taskResultsTimes, $params) {
        $dataTable = \Lava::DataTable();
        $dataTable->addStringColumn('')
            ->addNumberColumn('Count');
        $timeZone = 3 * 60 * 60; // 3 hours in seconds
        $vAxis["ticks"] = [1];
        if ($taskResultsTimes) {
            $result = $this->statisticalDataService->calculateGroupedDataForChart($taskResultsTimes, $timeZone,
                $params["interval"], $params["period"]);
            foreach ($result['rows'] as $row)
                $dataTable->addRow($row);
            //$vAxis['format'] = '#.#';
            $vAxis["ticks"] = $result["ticks"];
        }

        \Lava::ColumnChart('taskResultsChart', $dataTable, [
            'title' => 'Task results',
            'vAxis' => $vAxis,
            'titleTextStyle' => [
                'color'    => '#eb6b2c',
                'fontSize' => 14
            ]
        ]);
    }
}