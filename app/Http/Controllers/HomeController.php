<?php
namespace App\Http\Controllers;


class HomeController extends Controller
{
    public function index() {
        return view('home');
    }

    public function indexAdmin() {
        return view('home_admin');
    }

    public function download() {
        return view('download');
    }
}