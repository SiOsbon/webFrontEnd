<?php

include_once('simple_html_dom.php');

include_once('TokenProjectClass.php');

include_once('TokenMarket.php');
include_once('CoinMarketCap.php');
include_once('CryptoCompare.php');
include_once('IcoRatings.php');
include_once('SimilarWeb.php');

include_once('helpers.php');

if (isset($_GET['link'])){
	
	$tp = new TokenProjectClass();
	
	$link = $_GET['link'];
	
	$tp->baseInfo->domain = getDomainFromUrl($link);

	$tp = getDataFromTokenMarket($tp);

	if ($tp->baseInfo->status == 'trading'){
		$tp = getDataFromCoinMarketCap($tp);
	}

	$tp = GetDataFromCryptoCompare($tp);

	if ($tp->baseInfo->status == 'ICO'){
		$tp = GetRatings($tp);
	}

	$tp = GetTraffic($tp); 

}
else{ $tp = null;  $tp->error  = "Link is not set"; }

//	Show json
header('Content-type: application/json');
$x = json_encode($tp);
echo $x;

?>
