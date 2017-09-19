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

    public function generateNodeExecutedTasksChart($taskCounts) {
        $dataTable = \Lava::DataTable();
        $dataTable->addStringColumn('')
            ->addNumberColumn('Count');
        $timeZone = 3 * 60 * 60; // 3 hours in seconds
        $result = $this->statisticalDataService->calculateGroupedDataForChart($taskCounts, $timeZone, 60 * 60, 24);

        foreach ($result['rows'] as $row)
            $dataTable->addRow($row);

        //$vAxis['format'] = '#.#';
        $vAxis["ticks"] = $result["ticks"];

        \Lava::ColumnChart('nodeTaskChart', $dataTable, [
            'title' => 'Node executed task count',
            'vAxis' => $vAxis,
            'titleTextStyle' => [
                'color'    => '#eb6b2c',
                'fontSize' => 14
            ]
        ]);
    }

    public function generateDataContractsCountChart($dataContractCounts) {
        $dataTable = \Lava::DataTable();
        $dataTable->addStringColumn('')
            ->addNumberColumn('Count');
        $timeZone = 3 * 60 * 60; // 3 hours in seconds

        $result = $this->statisticalDataService->calculateDataForChart($dataContractCounts, $timeZone, 60*60, 24);
        foreach ($result['rows'] as $row)
            $dataTable->addRow($row);

        $vAxis["ticks"] = $result["ticks"];

        \Lava::ColumnChart('dataContractChart', $dataTable, [
            'title' => 'Active data contracts',
            'vAxis' => $vAxis,

            'titleTextStyle' => [
                'color'    => '#eb6b2c',
                'fontSize' => 14
            ]
        ]);
    }

    public function generateTasksCountChart($tasksCount) {
        $dataTable = \Lava::DataTable();
        $dataTable->addStringColumn('')
            ->addNumberColumn('Count');
        $timeZone = 3 * 60 * 60; // 3 hours in seconds

        $result = $this->statisticalDataService->calculateDataForChart($tasksCount, $timeZone, 60*60, 24);
        foreach ($result['rows'] as $row)
            $dataTable->addRow($row);

        $vAxis["ticks"] = $result["ticks"];

        \Lava::ColumnChart('tasksChart', $dataTable, [
            'title' => 'Active tasks count',
            'vAxis' => $vAxis,

            'titleTextStyle' => [
                'color'    => '#eb6b2c',
                'fontSize' => 14
            ]
        ]);
    }
}