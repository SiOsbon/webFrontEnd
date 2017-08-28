<?php
/**
 * Created by PhpStorm.
 * User: Aurimas
 * Date: 2017-08-28
 * Time: 08:49
 */

namespace App\Http\Controllers;


class HomeController
{
    public function index() {
        return view('home');
    }
}