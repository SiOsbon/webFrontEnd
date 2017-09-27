<?php
/**
 * Created by PhpStorm.
 * User: Aurimas
 * Date: 2017-09-27
 * Time: 12:49
 */

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ScraperController extends Controller
{

    public function index(Request $request) {
        $input = $request->input();
        $result["status"] = 0;
        if ($input["targetUrl"]) {
            if (!Cache::has($input["targetUrl"])) {
                $url = $input["targetUrl"];
                $curl = curl_init($url);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
                $response = curl_exec($curl);
                $pattern = "#<\s*?body\b[^>]*>(.*?)</body\b[^>]*>#s";
                preg_match($pattern, $response, $matches);
                $html = preg_replace('/<a[^>]+\>/i', "", $matches[1]);
                $result["body"] = $html;
                curl_close($curl);
                $result["from_cache"] = 0;
                Cache::put($input["targetUrl"], $result["body"], 10);
            } else {
                $result["body"] = Cache::get($input["targetUrl"]);
                $result["from_cache"] = 1;
            }
            $result["status"] = 1;
            $result['targetUrl'] = $input["targetUrl"];
        }
        return response()->json($result);
    }

}