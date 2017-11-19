<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PJClient;
use JonnyW\PhantomJs\DependencyInjection\ServiceContainer;

class PhantomController extends Controller
{
    public function index() {
        echo "you are here";
        $client = PJClient::getInstance();
        //var_dump($client);
        //$client->getEngine()->setPath('D:\_users\aurimas\_dev\daratus\web-front-end\vendor\bin\phantomjs.exe');
        // reikejo suinstaliuoti sudo apt-get install php-bz2

        /*$client->getEngine()->setPath('/srv/daratus/vendor/bin/phantomjs');
//        $script_location = '/srv/daratus/vendor/bin/phantom.js';
//        $serviceContainer = ServiceContainer::getInstance();
//        $procedureLoader = $serviceContainer->get('procedure_loader_factory')
//            ->createProcedureLoader($script_location);
//        $client->getProcedureLoader()->addLoader($procedureLoader);*
        $client->isLazy();
        //var_dump($client);
        $request = $client->getMessageFactory()->createRequest('https://www.similarweb.com/website/bankera.com', 'GET');
        $response = $client->getMessageFactory()->createResponse();
        $request->setTimeout(5000);
        // Send the request
        $client->send($request, $response);
        echo "<pre>";
        echo htmlspecialchars($response->getContent());
        echo "</pre>";*/
        //$url = escapeshellarg('https://www.similarweb.com/website/bankera.com');

        $url = escapeshellarg('https://widget.similarweb.com/traffic/bankera.com');
        $script = "/srv/daratus/vendor/bin/phantom.js";
        $contents = shell_exec("/srv/daratus/vendor/bin/phantomjs ".$script." ".$url);
        echo "<pre>";
        echo htmlspecialchars($contents);
        echo "</pre>";

        /*$myUrl = "https://www.similarweb.com/website/bankera.com";
        $browser = \MTS\Factories::getDevices()->getLocalHost()->getBrowser('phantomjs');
        $windowObj = $browser->getNewWindow($myUrl);
        $domData = $windowObj->getDom();
        echo $domData;*/

        /*if($response->getStatus() === 200) {

            // Dump the requested page content
            echo "---".$response->getContent();
        }*/
    }
}
