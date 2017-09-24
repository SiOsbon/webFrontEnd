<?php
/**
 * Created by PhpStorm.
 * User: Aurimas
 * Date: 2017-09-19
 * Time: 14:55
 */

namespace App\Services;


class StatisticalDataService
{
    public function calculateGroupedDataForChart($data, $timeZone, $interval, $period) {
        $count = $period / $interval;
        $current = time() + $timeZone;
        $rows = [];
        $max = 0;
        for ($i=0; $i<$count; $i++) {
            $newTs1 = $current - $interval * $i;
            $newTs2 = $current - $interval * ($i + 1);
            $cnt = 0;
            for ($j = 0; $j<count($data); $j++) {
                if ($data[$j] / 1000 + $timeZone <= $newTs1 and $data[$j] / 1000 + $timeZone >= $newTs2) {
                    $cnt++;
                    if ($cnt > $max)
                        $max = $cnt;
                }
            }

            $dt = new \DateTime();
            $dt->setTimestamp($newTs2);
            if ($interval < 3600)
                $rows[] = [$dt->format('H').":".$dt->format('i'), $cnt];
            else
                $rows[] = [$dt->format('H').":00", $cnt];
        }
        $result['rows'] = array_reverse($rows);

        $ticks = [];
        for ($i=0; $i<=$max + 1; $i++) {
            $ticks[] = $i;
        }
        $result['ticks'] = $ticks;
        return $result;
    }

    public function calculateDataForChart($data, $timeZone, $interval, $period) {
        $count = $period / $interval;
        ksort($data);
        $current = time() + $timeZone;
        $rows = [];
        $max = 0;
        for ($i=0; $i<$count; $i++) {
            $newTs1 = $current - $interval * $i;
            $newTs2 = $current - $interval * ($i + 1);
            $cnt = 0;
            foreach ($data as $key => $value) {
                if ($key / 1000 + $timeZone <= $newTs1 and $key / 1000 + $timeZone >= $newTs2) {
                    $cnt = $value;
                    if ($cnt > $max)
                        $max = $cnt;
                    break;
                }
            }
            $dt = new \DateTime();
            $dt->setTimestamp($newTs2);
            if ($interval < 3600)
                $rows[] = [$dt->format('H').":".$dt->format('i'), $cnt];
            else
                $rows[] = [$dt->format('H').":00", $cnt];
        }
        $result['rows'] = array_reverse($rows);

        $ticks = [];
        for ($i=0; $i<=$max + 1; $i++) {
            $ticks[] = $i;
        }

        $result['ticks'] = $ticks;
        return $result;
    }
}