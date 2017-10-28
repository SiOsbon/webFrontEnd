<?php

namespace App\Helpers;

class AppHelper
{

    public function getIntervalSelecValues() {
        return ["300" => "5 minutes",
            "600" => "10 minutes",
            "3600" => "1 hour",
            "7200" => "2 hour"];
    }

    public function getPeriodSelectValues() {
        return ["3600" => "1 hour",
            "10800" => "3 hours",
            "43200" => "12 hours",
            "86400" => "24 hours",
            "172800" => "48 hours"];
    }

    public static function instance()
    {
        return new AppHelper();
    }

}