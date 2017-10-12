<?php
/**
 * Created by PhpStorm.
 * User: Aurimas
 * Date: 2017-09-27
 * Time: 12:49
 */

namespace App\Http\Controllers;
use App\Helpers\ScraperHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ScraperController extends Controller
{

    private $scraperHelper;

    public function __construct(ScraperHelper $scraperHelper)
    {
        $this->scraperHelper = $scraperHelper;
    }

    public function index(Request $request) {
        $input = $request->input();
        $result["status"] = 0;
        $result['newTargetUrl'] = "";
        if ($input["targetUrl"]) {
            if (!Cache::has($input["targetUrl"])) {
                $url = $input["targetUrl"];
                $c = $this->scraperHelper->getFinalResponse($url);
                $response = $c["content"];
                if ($this->scraperHelper->isHtml($response)) {
                    $tags = ['head', 'script', 'javascript'];
                    $response = $this->scraperHelper->processHtml($response, $tags);
                    //$response = preg_replace('/<a[^>]+\>/i', "", $response);
                    //$response = preg_replace('/<a(.*)href="([^"]*)"(.*)>/', '<a$1href="javascript:void(0);"$3>', $response);
                    $pattern = "#<\s*?body\b[^>]*>(.*?)</body\b[^>]*>#s";
                    preg_match($pattern, $response, $matches);
                    $result["body"] = $matches[1];
                    $result["from_cache"] = 0;
                    $result['newTargetUrl'] = $c["url"];
                    $c["content"] = $response;
                    Cache::put($input["targetUrl"], $c, 10);
                } else {
                    $result["error"] = "not html";
                    $result["new_token"] = csrf_token();
                    return response()->json($result);
                }
            } else {
                $c = Cache::get($input["targetUrl"]);
                $result["body"] = $c["content"];
                $result['newTargetUrl'] = $c["url"];
                $result["from_cache"] = 1;
            }
            $result["status"] = 1;
            $result['targetUrl'] = $input["targetUrl"];
            //$result['newTargetUrl'] = $c["url"];
            $result["new_token"] = csrf_token();
        }
        return response()->json($result);
    }

}